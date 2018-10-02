<?php /* Template Name: About page */ ?>

<?php get_header(); ?>

<div class="header">
    <div class="container">
        <i class="material-icons">info_outline</i>
        <h1>About</h1>
    </div>
</div>
<div class="content">
    <div class="container" style="text-align: justify">
        <img class="right" style="padding: 0 0 15px 15px" src="<?php bloginfo('template_url');?>/img/Mike_Muuss.jpg" alt="">
        <p><b>BRL-CAD</b> is a powerful cross-platform Open Source combinatorial Constructive Solid Geometry (CSG) solid modeling system that includes interactive 3D solid geometry editing, high-performance ray-tracing support for rendering and geometric
            analysis, network-distributed framebuffer support, image and signal-processing tools, path-tracing and photon mapping support for realistic image synthesis, a system performance analysis benchmark suite, an embedded scripting interface, and
            libraries for robust high-performance geometric representation and analysis. For more than 20 years, BRL-CAD has been the primary tri-service solid modeling CAD system used by the U.S. military to model weapons systems for vulnerability and
            lethality analyses.
        </p>
        <p>The solid modeling system is frequently used in a wide range of military, academic, and industrial applications including in the design and analysis of vehicles, mechanical parts, and architecture. The package has also been used in radiation dose
            planning, medical visualization, computer graphics education, CSG concepts and modeling education, and system performance benchmark testing among other purposes. BRL-CAD supports a great variety of geometric representations including an extensive
            set of traditional CSG primitive implicit solids such as boxes, ellipsoids, cones, and tori, as well as explicit solids made from closed collections of Uniform B-Spline Surfaces, Non-Uniform Rational B-Spline (NURBS) surfaces, n-Manifold Geometry
            (NMG), and purely faceted mesh geometry.
        </p>
        <p> All geometric objects may be combined using boolean set-theoretic CSG operations including union, intersection, and difference. BRL-CAD has been under active development with a portability heritage that includes systems such as a DEC VAX-11/780
            running 4.3 BSD; DECStations running ULTRIX; Silicon Graphics 3030, 4D "IRIS", O2, Onyx, and Origin systems running various versions of IRIX; Sun Microsystems Sun-3 and Sun-4 Sparcs running SunOS; the Cray 1, Cray X-MP, Cray Y-MP, and Cray
            2 running UNICOS; DEC Alpha AXP running OSF/1; Apple Macintosh II running A/UX; iPSC/860 Hypercube running NX/2; the Alliant FX/8, FX/80, and FX/2800; Gould/Encore SEL PowerNode6000/9000 and NP1; NeXT workstations; IBM RS/6000; HPPA 9000/700
            running HPUX; Ardent/Stardent; Encore Multi-Max; and much more.
        </p>
        <p> BRL-CAD is a collection of more than 400 tools, utilities, and applications comprising more than a million lines of source code. The package is intentionally designed to be extensively cross-platform and is actively developed on and maintained
            for many common operating system environments including for BSD, Linux, Solaris, Mac OS X, and Windows among others. BRL-CAD is distributed in binary and source code form as free open source software (FOSS), provided under Open Source Initiative
            (OSI) approved license terms. Mike Muuss began the initial architecture and design of BRL-CAD back in 1979. Development as a unified package began in 1983. The first public release was made in 1984. BRL-CAD became an open source project on
            21 December 2004.
        </p>
    </div>
</div>


<?php get_footer(); ?>