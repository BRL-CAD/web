/*!
 * VisualEditor UserInterface Window class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface window.
 *
 * @class
 * @abstract
 * @extends ve.Element
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 * @fires initialize
 */
ve.ui.Window = function VeUiWindow( windowSet, config ) {
	// Parent constructor
	ve.Element.call( this, config );

	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.windowSet = windowSet;
	this.visible = false;
	this.opening = false;
	this.closing = false;
	this.frame = null;
	this.$frame = this.$$( '<div>' );

	// Initialization
	this.$
		.addClass( 've-ui-window' )
		.append( this.$frame );
	this.frame = new ve.ui.Frame();
	this.$frame
		.addClass( 've-ui-window-frame' )
		.append( this.frame.$ );

	// Events
	this.frame.connect( this, { 'initialize': 'onFrameInitialize' } );
};

/* Inheritance */

OO.inheritClass( ve.ui.Window, ve.Element );

OO.mixinClass( ve.ui.Window, OO.EventEmitter );

/* Events */

/**
 * @event initialize
 */

/**
 * @event setup
 * @param {ve.ui.Window} win Window that's been setup
 */

/**
 * @event open
 * @param {ve.ui.Window} win Window that's been opened
 */

/**
 * @event close
 * @param {ve.ui.Window} win Window that's been closed
 * @param {string} action Action that caused the window to be closed
 */

/* Static Properties */

/**
 * Symbolic name of icon.
 *
 * @static
 * @inheritable
 * @property {string}
 */
ve.ui.Window.static.icon = 'window';

/**
 * Localized message for title.
 *
 * @static
 * @inheritable
 * @property {string}
 */
ve.ui.Window.static.titleMessage = null;

/* Methods */

/**
 * Handle frame initialize event.
 *
 * @method
 */
ve.ui.Window.prototype.onFrameInitialize = function () {
	this.initialize();
	this.emit( 'initialize' );
};

/**
 * Handle the window being initialized.
 *
 * @method
 */
ve.ui.Window.prototype.initialize = function () {
	// Properties
	this.$title = this.$$( '<div class="ve-ui-window-title"></div>' );
	if ( this.getTitle() ) {
		this.setTitle();
	}
	this.$icon = this.$$( '<div class="ve-ui-window-icon"></div>' )
		.addClass( 've-ui-icon-' + this.constructor.static.icon );
	this.$head = this.$$( '<div class="ve-ui-window-head"></div>' );
	this.$body = this.$$( '<div class="ve-ui-window-body"></div>' );
	this.$foot = this.$$( '<div class="ve-ui-window-foot"></div>' );
	this.$overlay = this.$$( '<div class="ve-ui-window-overlay"></div>' );

	// Initialization
	this.frame.$content.append(
		this.$head.append( this.$icon, this.$title ),
		this.$body,
		this.$foot,
		this.$overlay
	);
};

/**
 * Handle the window being opened.
 *
 * Any changes to the document in that need to be done prior to opening should be made here.
 *
 * To be notified after this method is called, listen to the `setup` event.
 *
 * @method
 */
ve.ui.Window.prototype.onSetup = function () {
	// This is a stub, override functionality in child classes
};

/**
 * Handle the window being opened.
 *
 * Any changes to the window that need to be done prior to opening should be made here.
 *
 * To be notified after this method is called, listen to the `open` event.
 *
 * @method
 */
ve.ui.Window.prototype.onOpen = function () {
	// This is a stub, override functionality in child classes
};

/**
 * Handle the window being closed.
 *
 * Any changes to the document that need to be done prior to closing should be made here.
 *
 * To be notified after this method is called, listen to the `close` event.
 *
 * @method
 * @param {string} action Action that caused the window to be closed
 */
ve.ui.Window.prototype.onClose = function () {
	// This is a stub, override functionality in child classes
};

/**
 * Check if window is visible.
 *
 * @method
 * @returns {boolean} Window is visible
 */
ve.ui.Window.prototype.isVisible = function () {
	return this.visible;
};

/**
 * Get the window frame.
 *
 * @method
 * @returns {ve.ui.Frame} Frame of window
 */
ve.ui.Window.prototype.getFrame = function () {
	return this.frame;
};

/**
 * Get the window set.
 *
 * @method
 * @returns {ve.ui.WindowSet} Window set
 */
ve.ui.Window.prototype.getWindowSet = function () {
	return this.windowSet;
};

/**
 * Get the title of the window.
 *
 * Use .static.titleMessage to set this unless you need to do something fancy.
 * @returns {string} Window title
 */
ve.ui.Window.prototype.getTitle = function () {
	return ve.msg( this.constructor.static.titleMessage );
};

/**
 * Set the size of window frame.
 *
 * @param {number} [width=auto] Custom width
 * @param {number} [height=auto] Custom height
 */
ve.ui.Window.prototype.setSize = function ( width, height ) {
	if ( !this.frame.$content ) {
		return;
	}

	this.frame.$.css( {
		'width': width === undefined ? 'auto' : width,
		'height': height === undefined ? 'auto' : height
	} );
};

/**
 * Set the title of the window.
 *
 * @param {string} [customTitle] Custom title, override the static.titleMessage
 */
ve.ui.Window.prototype.setTitle = function ( customTitle ) {
	this.$title.text( customTitle || this.getTitle() );
};

/**
 * Set the height of window to fit with contents.
 *
 * @param {number} [min=0] Min height
 * @param {number} [max] Max height (defaults to content's outer height)
 */
ve.ui.Window.prototype.fitHeightToContents = function ( min, max ) {
	var height = this.frame.$content.outerHeight();

	this.frame.$.css(
		'height', Math.max( min || 0, max === undefined ? height : Math.min( max, height ) )
	);
};

/**
 * Set the width of window to fit with contents.
 *
 * @param {number} [min=0] Min height
 * @param {number} [max] Max height (defaults to content's outer width)
 */
ve.ui.Window.prototype.fitWidthToContents = function ( min, max ) {
	var width = this.frame.$content.outerWidth();

	this.frame.$.css(
		'width', Math.max( min || 0, max === undefined ? width : Math.min( max, width ) )
	);
};

/**
 * Set the position of window to fit with contents..
 *
 * @param {string} left Left offset
 * @param {string} top Top offset
 */
ve.ui.Window.prototype.setPosition = function ( left, top ) {
	this.$.css( { 'left': left, 'top': top } );
};

/**
 * Open window.
 *
 * @method
 * @fires setup
 * @fires open
 */
ve.ui.Window.prototype.open = function () {
	if ( !this.opening ) {
		this.opening = true;
		this.onSetup();
		this.emit( 'setup' );
		this.$.show();
		this.visible = true;
		this.frame.$.focus();
		this.frame.run( ve.bind( function () {
			this.onOpen();
			this.opening = false;
			this.emit( 'open' );
		}, this ) );
	}
};

/**
 * Close window.
 *
 * This method guards against recursive calling internally. This protects against changes made while
 * closing the window which themselves would cause the window to be closed from causing an infinate
 * loop.
 *
 * @method
 * @param {string} action Action that caused the window to be closed
 * @fires close
 */
ve.ui.Window.prototype.close = function ( action ) {
	if ( !this.closing ) {
		this.closing = true;
		this.$.hide();
		this.visible = false;
		this.onClose( action );
		this.frame.$content.find( ':focus' ).blur();
		this.emit( 'close', action );
		// This is at the bottom in case handlers of the close event try to close the window again
		this.closing = false;
	}
};
