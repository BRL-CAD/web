/*!
 * VisualEditor UserInterface Context class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface context.
 *
 * @class
 * @extends ve.Element
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.Context = function VeUiContext( surface, config ) {
	// Parent constructor
	ve.Element.call( this, config );

	// Properties
	this.surface = surface;
	this.inspectors = {};
	this.visible = false;
	this.showing = false;
	this.hiding = false;
	this.openingInspector = false;
	this.selecting = false;
	this.relocating = false;
	this.embedded = false;
	this.selection = null;
	this.toolbar = null;
	this.afterChangeTimeout = null;
	this.popup = new ve.ui.PopupWidget( { '$$': this.$$, '$container': this.surface.getView().$ } );
	this.$menu = this.$$( '<div>' );
	this.inspectors = new ve.ui.SurfaceWindowSet( surface, ve.ui.inspectorFactory );

	// Initialization
	this.$.addClass( 've-ui-context' ).append( this.popup.$ );
	this.inspectors.$.addClass( 've-ui-context-inspectors' );
	this.popup.$body.append(
		this.$menu.addClass( 've-ui-context-menu' ),
		this.inspectors.$.addClass( 've-ui-context-inspectors' )
	);

	// Events
	this.surface.getModel().connect( this, { 'change': 'onChange' } );
	this.surface.getView().connect( this, {
		'selectionStart': 'onSelectionStart',
		'selectionEnd': 'onSelectionEnd',
		'relocationStart': 'onRelocationStart',
		'relocationEnd': 'onRelocationEnd'
	} );
	this.inspectors.connect( this, {
		'setup': 'onInspectorSetup',
		'open': 'onInspectorOpen',
		'close': 'onInspectorClose'
	} );

	this.$$( this.getElementWindow() ).on( {
		'resize': ve.bind( this.update, this )
	} );
	this.$.add( this.$menu )
		.on( 'mousedown', false );
};

/* Inheritance */

OO.inheritClass( ve.ui.Context, ve.Element );

/* Methods */

/**
 * Handle selection changes in the model.
 *
 * Changes are ignored while the user is selecting text or relocating content, apart from closing
 * the popup if it's open. While an inspector is opening or closing, all changes are ignored so as
 * to prevent inspectors that change the selection from within their open/close handlers from
 * causing issues.
 *
 * The response to selection changes is deferred to prevent close handlers that process
 * changes from causing this function to recurse. These responses are also batched for efficiency,
 * so that if there are three selection changes in the same tick, afterChange() only runs once.
 *
 * @method
 * @see #afterChange
 * @param {ve.dm.Transaction[]} transactions Change transactions
 * @param {ve.Range} selection Change selection
 */
ve.ui.Context.prototype.onChange = function ( transactions, selection ) {
	if ( selection && !this.openingInspector && !this.hiding ) {
		if ( this.afterChangeTimeout === null ) {
			this.afterChangeTimeout = setTimeout( ve.bind( this.afterChange, this ) );
		}
	}
};

/**
 * Deferred response to one or more selection changes.
 *
 * Update the context menu for the new selection, except if the user is selecting or relocating
 * content. If the popup is open, close it, even while selecting or relocating.
 */
ve.ui.Context.prototype.afterChange = function () {
	this.afterChangeTimeout = null;
	if ( this.popup.isVisible() ) {
		this.hide();
		this.update();
	} else if ( !this.selecting && !this.relocating ) {
		this.update();
	}
};

/**
 * Handle selection start events on the view.
 *
 * @method
 */
ve.ui.Context.prototype.onSelectionStart = function () {
	this.selecting = true;
	this.hide();
};

/**
 * Handle selection end events on the view.
 *
 * @method
 */
ve.ui.Context.prototype.onSelectionEnd = function () {
	this.selecting = false;
	if ( !this.relocating ) {
		this.update();
	}
};

/**
 * Handle selection start events on the view.
 *
 * @method
 */
ve.ui.Context.prototype.onRelocationStart = function () {
	this.relocating = true;
	this.hide();
};

/**
 * Handle selection end events on the view.
 *
 * @method
 */
ve.ui.Context.prototype.onRelocationEnd = function () {
	this.relocating = false;
	this.update();
};

/**
 * Handle an inspector being setup.
 *
 * @method
 * @param {ve.ui.SurfaceInspector} inspector Inspector that's been setup
 */
ve.ui.Context.prototype.onInspectorSetup = function () {
	this.selection = this.surface.getModel().getSelection();
};

/**
 * Handle an inspector being opened.
 *
 * @method
 * @param {ve.ui.SurfaceInspector} inspector Inspector that's been opened
 */
ve.ui.Context.prototype.onInspectorOpen = function () {
	// Transition between menu and inspector
	this.show( true );
};

/**
 * Handle an inspector being closed.
 *
 * @method
 * @param {ve.ui.SurfaceInspector} inspector Inspector that's been opened
 * @param {boolean} accept Changes have been accepted
 */
ve.ui.Context.prototype.onInspectorClose = function () {
	this.update();
};

/**
 * Gets the surface the context is being used in.
 *
 * @method
 * @returns {ve.ui.Surface} Surface of context
 */
ve.ui.Context.prototype.getSurface = function () {
	return this.surface;
};

/**
 * Destroy the context, removing all DOM elements.
 *
 * @method
 * @returns {ve.ui.Context} Context UserInterface
 * @chainable
 */
ve.ui.Context.prototype.destroy = function () {
	this.$.remove();
	return this;
};

/**
 * Updates the context menu.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @param {boolean} [repositionOnly=false] The context is only being moved so don't fade in
 * @chainable
 */
ve.ui.Context.prototype.update = function ( transition, repositionOnly ) {
	var i, nodes, tools, tool,
		fragment = this.surface.getModel().getFragment( null, false ),
		selection = fragment.getRange(),
		inspector = this.inspectors.getCurrent();

	if ( inspector && selection.equals( this.selection ) ) {
		// There's an inspector, and the selection hasn't changed, update the position
		this.show( transition, repositionOnly );
	} else {
		// No inspector is open, or the selection has changed, show a menu of available inspectors
		tools = ve.ui.toolFactory.getToolsForAnnotations( fragment.getAnnotations() );
		nodes = fragment.getCoveredNodes();
		for ( i = 0; i < nodes.length; i++ ) {
			if ( nodes[i].range && nodes[i].range.isCollapsed() ) {
				nodes.splice( i, 1 );
				i--;
			}
		}
		if ( nodes.length === 1 ) {
			tool = ve.ui.toolFactory.getToolForNode( nodes[0].node );
			if ( tool ) {
				tools.push( tool );
			}
		}
		if ( tools.length ) {
			// There's at least one inspectable annotation, build a menu and show it
			this.$menu.empty();
			if ( this.toolbar ) {
				this.toolbar.destroy();
			}
			this.toolbar = new ve.ui.SurfaceToolbar( this.surface );
			this.toolbar.setup( [ { 'include' : tools } ] );
			this.$menu.append( this.toolbar.$ );
			this.show( transition, repositionOnly );
			this.toolbar.initialize();
		} else if ( this.visible ) {
			// Nothing to inspect
			this.hide();
		}
	}

	// Remember selection for next time
	this.selection = selection.clone();

	return this;
};

/**
 * Updates the position and size.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @chainable
 */
ve.ui.Context.prototype.updateDimensions = function ( transition ) {
	var $node, $container, focusableOffset, focusableWidth, nodePosition, cursorPosition, position,
		documentOffset, nodeOffset,
		surface = this.surface.getView(),
		inspector = this.inspectors.getCurrent(),
		focusedNode = surface.getFocusedNode(),
		surfaceOffset = surface.$.offset(),
		rtl = this.surface.view.getDir() === 'rtl';

	$container = inspector ? this.inspectors.$ : this.$menu;
	if ( focusedNode ) {
		// We're on top of a node
		$node = focusedNode.$focusable || focusedNode.$;
		if ( this.embedded ) {
			// Get the position relative to the surface it is embedded in
			focusableOffset = ve.Element.getRelativePosition(
				$node, this.surface.$
			);
			position = { 'y': focusableOffset.top };
			// When context is embedded in RTL, it requires adjustments to the relative
			// positioning (pop up on the other side):
			if ( rtl ) {
				position.x = focusableOffset.left;
				this.popup.align = 'left';
			} else {
				focusableWidth = $node.outerWidth();
				position.x = focusableOffset.left + focusableWidth;
				this.popup.align = 'right';
			}
		} else {
			// The focused node may be in a wrapper, so calculate the offset relative to the document
			documentOffset = surface.getDocument().documentNode.$.offset();
			nodeOffset = $node.offset();
			nodePosition = {
				top: nodeOffset.top - documentOffset.top,
				left: nodeOffset.left - documentOffset.left
			};
			// Get the position of the focusedNode:
			position = { 'x': nodePosition.left, 'y': nodePosition.top + $node.outerHeight() };
			// When the context is displayed in LTR, it should be on the right of the node
			if ( !rtl ) {
				position.x += $node.outerWidth();
			}
			this.popup.align = 'center';
		}
	} else {
		// We're on top of a selected text
		// Get the position of the cursor
		cursorPosition = surface.getSelectionRect();
		if ( !cursorPosition ) {
			// The surface apparently isn't selected, so getSelectionRect() returned null.
			// This shouldn't happen because the context is only supposed to be displayed in
			// response to a selection, but for some reason this does happen in phantomjs.
			// We can't update the context position if we don't know where the selection is,
			// so just bail.
			return this;
		}

		// Correct for surface offset:
		position = {
			'x': cursorPosition.end.x - surfaceOffset.left,
			'y': cursorPosition.end.y - surfaceOffset.top
		};
		this.popup.align = 'center';
	}

	this.$.css( { 'left': position.x, 'top': position.y } );

	this.popup.display(
		$container.outerWidth( true ),
		$container.outerHeight( true ),
		transition
	);

	return this;
};

/**
 * Shows the context menu.
 *
 * @method
 * @param {boolean} [transition=false] Use a smooth transition
 * @param {boolean} [repositionOnly=false] The context is only being moved so don't fade in
 * @chainable
 */
ve.ui.Context.prototype.show = function ( transition, repositionOnly ) {
	var inspector = this.inspectors.getCurrent(),
		focusedNode = this.surface.getView().getFocusedNode();

	if ( !this.showing ) {
		this.showing = true;

		this.$.show();
		this.popup.show();

		// Show either inspector or menu
		if ( inspector ) {
			this.$menu.hide();
			this.inspectors.$.show();
			if ( !repositionOnly ) {
				inspector.$.css( 'opacity', 0 );
			}
			// Update size and fade the inspector in after animation is complete
			setTimeout( ve.bind( function () {
				inspector.fitHeightToContents();
				this.updateDimensions( transition );
				inspector.$.css( 'opacity', 1 );
			}, this ), 200 );
		} else {
			this.inspectors.$.hide();
			this.embedded = (
				focusedNode &&
				focusedNode.$focusable.outerHeight() > this.$menu.outerHeight() * 2 &&
				focusedNode.$focusable.outerWidth() > this.$menu.outerWidth() * 2
			);
			this.popup.useTail( !this.embedded );
			this.$menu.show();
		}

		this.updateDimensions( transition );

		this.visible = true;
		this.showing = false;
	}

	return this;
};

/**
 * Hides the context menu.
 *
 * @method
 * @chainable
 */
ve.ui.Context.prototype.hide = function () {
	var inspector = this.inspectors.getCurrent();

	// Guard against recursion: closing the inspector causes onInspectorClose to call us again
	if ( !this.hiding ) {
		this.hiding = true;
		if ( inspector ) {
			inspector.close( 'hide' );
		}
		this.popup.hide();
		this.$.hide();
		this.visible = false;
		this.hiding = false;
	}
	return this;
};

/**
 * Opens a given inspector.
 *
 * @method
 * @param {string} name Symbolic name of inspector
 * @param {Object} [config] Configuration options to be sent to the inspector class constructor
 * @chainable
 */
ve.ui.Context.prototype.openInspector = function ( name, config ) {
	if ( !this.inspectors.currentWindow ) {
		this.openingInspector = true;
		this.inspectors.open( name, config );
		this.openingInspector = false;
	}
	return this;
};
