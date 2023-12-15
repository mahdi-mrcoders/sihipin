<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ADMIN - SIHIPIN POLKAM</title>
    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/base/vendor.bundle.base.css">
    
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.png" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" type="text/css">
</head>

<body>
    <div id="app"></div>

    <script src="{{ asset('assets') }}/vendors/base/vendor.bundle.base.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
    <!--library-->
    <script src="https://volodymyrbaydalka.github.io/docxjs/dist/docx-preview.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

    <script src="{{ mix('js/app.js') }}" type="text/javascript" defer></script>

    <script>
        (function($) {
            $(function() {
                var body = $('body');
                var contentWrapper = $('.content-wrapper');
                var scroller = $('.container-scroller');
                var footer = $('.footer');
                var sidebar = $('.sidebar');

                //Add active class to nav-link based on url dynamically
                //Active class can be hard coded directly in html file also as required

                function addActiveClass(element) {
                    if (current === "") {
                        //for root url
                        if (element.attr('href').indexOf("index.html") !== -1) {
                            element.parents('.nav-item').last().addClass('active');
                            if (element.parents('.sub-menu').length) {
                                element.closest('.collapse').addClass('show');
                                element.addClass('active');
                            }
                        }
                    } else {
                        //for other url
                        if (element.attr('href').indexOf(current) !== -1) {
                            element.parents('.nav-item').last().addClass('');
                            if (element.parents('.sub-menu').length) {
                                element.closest('.collapse').addClass('show');
                                element.addClass('active');
                            }
                            if (element.parents('.submenu-item').length) {
                                element.addClass('active');
                            }
                        }
                    }
                }

                var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
                $('.nav li a', sidebar).each(function() {
                    var $this = $(this);
                    addActiveClass($this);
                })

                $('.horizontal-menu .nav li a').each(function() {
                    var $this = $(this);
                    addActiveClass($this);
                })

                //Close other submenu in sidebar on opening any

                sidebar.on('show.bs.collapse', '.collapse', function() {
                    sidebar.find('.collapse.show').collapse('hide');
                });


                //Change sidebar and content-wrapper height
                applyStyles();

                function applyStyles() {
                    //Applying perfect scrollbar
                    if (!body.hasClass("rtl")) {
                        if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
                            const settingsPanelScroll = new PerfectScrollbar(
                                '.settings-panel .tab-content .tab-pane.scroll-wrapper');
                        }
                        if ($('.chats').length) {
                            const chatsScroll = new PerfectScrollbar('.chats');
                        }
                        if (body.hasClass("sidebar-fixed")) {
                            if ($('#sidebar').length) {
                                var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
                            }
                        }
                    }
                }

                $('[data-toggle="minimize"]').on("click", function() {
                    if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass(
                        'sidebar-absolute'))) {
                        body.toggleClass('sidebar-hidden');
                    } else {
                        body.toggleClass('sidebar-icon-only');
                    }
                });

                //checkbox and radios
                $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

                //Horizontal menu in mobile
                $('[data-toggle="horizontal-menu-toggle"]').on("click", function() {
                    $(".horizontal-menu .bottom-navbar").toggleClass("header-toggled");
                });
                // Horizontal menu navigation in mobile menu on click
                var navItemClicked = $('.horizontal-menu .page-navigation >.nav-item');
                navItemClicked.on("click", function(event) {
                    if (window.matchMedia('(max-width: 991px)').matches) {
                        if (!($(this).hasClass('show-submenu'))) {
                            navItemClicked.removeClass('show-submenu');
                        }
                        $(this).toggleClass('show-submenu');
                    }
                })

                $(window).scroll(function() {
                    if (window.matchMedia('(min-width: 992px)').matches) {
                        var header = $('.horizontal-menu');
                        if ($(window).scrollTop() >= 70) {
                            $(header).addClass('fixed-on-scroll');
                        } else {
                            $(header).removeClass('fixed-on-scroll');
                        }
                    }
                });
            });
        })(jQuery);
    </script>
</body>

</html>
