<?php
        // Add CTA Shortcode
        function cta_shortcode( $atts ) {
            global $post;
            
            $atts = shortcode_atts(
                array(
                    'id' => '',
                ),
                $atts,
                'cta'
            );
            
            if ( !empty( $atts['id']) ) {
                $posts = new WP_Query( array(
                    'post_type'     => 'simple_cta_popup',
                    'p'             => $atts['id'],
                    'post_status'   => 'publish'
                ) );
                $output = '';
                
                if ($posts->have_posts()) {
                    while($posts->have_posts()){
                        
                        $posts->the_post();
                        $output = '
                            <div class="cta_notif_content ' . get_post_meta( get_the_ID(), '_simple_cta_popup_location', true ) . '" id="slider">
                                <div class="cta_notif_close" id="cta-notif-close">x</div>
                                <div class="cta_notif_data">
                                    <div class="cta_notif_headline">' . get_post_meta( get_the_ID(), '_simple_cta_popup_notification_text', true ) . '</div>
                                </div>
                                <div class="cta_notif_button_wrapper"> 
                                    <a href="' . get_post_meta( get_the_ID(), '_simple_cta_popup_url', true ) . '" class="cta_notif_button" id="cta-notif-link">' . get_post_meta( get_the_ID(), '_simple_cta_popup_notification_button', true ) . '</a>
                                </div>
                            </div>
                            
                            <script>
                                function getCookie(key) {
                                    var keyValue = document.cookie.match(\'(^|;) ?\' + key + \'=([^;]*)(;|$)\');
                                    return keyValue ? keyValue[2] : null;
                                } 
                                
                                function setCookie(key, value) {
                                    var expires = new Date();
                                    expires.setTime(expires.getTime() + 31536000000); //1 year  
                                    document.cookie = key + \'=\' + value + \';expires=\' + expires.toUTCString();
                                }
                                
                                var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(\' OPR/\') >= 0;
                                var isFirefox = typeof InstallTrigger !== \'undefined\';
                                var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window[\'safari\'] || (typeof safari !== \'undefined\' && window[\'safari\'].pushNotification));
                                var isIE = /*@cc_on!@*/false || !!document.documentMode;
                                var isEdge = !isIE && !!window.StyleMedia;
                                var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
                                var isEdgeChromium = isChrome && (navigator.userAgent.indexOf("Edg") != -1);
                                var isBlink = (isChrome || isOpera) && !!window.CSS;
                                
                                // if (isOpera || isFirefox || isSafari || isIE || isEdge || isChrome || isEdgeChromium || isBlink) {
                                if (true) {
                                    var url = window.location.href;
                                    var arr = url.split("/");
                                    var result = arr[0] + "//" + arr[2];
                                    visit_api = result + "/wp-json/simple_cta_popup/v1/visited/' . $atts['id'] . '";
                                    click_api = result + "/wp-json/simple_cta_popup/v1/clicked/' . $atts['id'] . '";
                                    close_api = result + "/wp-json/simple_cta_popup/v1/closed/' . $atts['id'] . '";
                                    
                                    cookieName = "_simple_cta_popup_' . $atts['id'] . '";
                                    var cookieValue = getCookie(cookieName);
                                    
                                    var closeButton = document.getElementById("cta-notif-close");
                                    var ctaButton = document.getElementById("cta-notif-link");
                                    
                                    if (!cookieValue) {
                                        setCookie(cookieName, "visited");
                                        slide();
                                        ctaVisit();
                                    } else if (cookieValue == "visited") {
                                        slide();
                                    }
                                    
                                    function ctaVisit() {
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                            }
                                        };
                                        xhttp.open("GET", visit_api, true);
                                        xhttp.send();
                                    }
                                    
                                    function slide() {
                                        var element = document.getElementById("slider");
                                        if(element.classList.contains("expand")) {
                                            element.classList.toggle("expand");
                                        } else {
                                            setTimeout(function(){
                                                element.classList.toggle("expand");
                                            }, 1000);
                                        }
                                    }
                                    
                                    ctaButton.addEventListener("click", function (e) {
                                        e.preventDefault();
                                        var ctaURL = ctaButton.href; 
                                        setCookie(cookieName, "clicked");
                                        slide();
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                            }
                                        };
                                        xhttp.open("GET", click_api, true);
                                        xhttp.send();
                                        window.location.href = ctaURL;
                                    });
                                    
                                    closeButton.addEventListener("click", function () {
                                        setCookie(cookieName, "closed");
                                        slide();
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                            }
                                        };
                                        xhttp.open("GET", close_api, true);
                                        xhttp.send();
                                    })
                                }
                            </script>
                        ';
                    }
                }
                
                wp_reset_query();
                return html_entity_decode($output);
            }
        }
        add_shortcode( 'cta', 'cta_shortcode' );
        
        function simple_cta_popup_visit_columns($columns) {
            $columns['visit'] = 'نمایش';
            return $columns;
        }
        add_filter('manage_edit-simple_cta_popup_columns', 'simple_cta_popup_visit_columns');
        
        function scp_visit_columns_only($columns) {
            $columns['visit'] = 'نمایش';
            return $columns;
        }
        add_filter('manage_edit-simple_cta_popup_columns', 'scp_visit_columns_only');
        
        function simple_cta_popup_visit_columns_data($name) {
            global $post;
            switch ($name) {
                case 'visit':
                    $visit = get_post_meta($post->ID, '_simple_cta_popup_visit', true);
                    echo $visit;
            }
        }
        add_action('manage_posts_custom_column',  'simple_cta_popup_visit_columns_data');
        
        function simple_cta_popup_click_columns($columns) {
            $columns['click'] = 'کلیک';
            return $columns;
        }
        add_filter('manage_edit-simple_cta_popup_columns', 'simple_cta_popup_click_columns');
        
        function scp_click_columns_only($columns) {
            $columns['click'] = 'کلیک';
            return $columns;
        }
        add_filter('manage_edit-simple_cta_popup_columns', 'scp_click_columns_only');
        
        function simple_cta_popup_click_columns_data($name) {
            global $post;
            switch ($name) {
                case 'click':
                    $click = get_post_meta($post->ID, '_simple_cta_popup_click', true);
                    echo $click;
            }
        }
        add_action('manage_posts_custom_column',  'simple_cta_popup_click_columns_data');
        
        function simple_cta_popup_close_columns($columns) {
            $columns['close'] = 'بستن';
            return $columns;
        }
        add_filter('manage_edit-simple_cta_popup_columns', 'simple_cta_popup_close_columns');
        
        function scp_close_columns_only($columns) {
            $columns['close'] = 'بستن';
            return $columns;
        }
        add_filter('manage_edit-simple_cta_popup_columns', 'scp_close_columns_only');
        
        function simple_cta_popup_close_columns_data($name) {
            global $post;
            switch ($name) {
                case 'close':
                    $close = get_post_meta($post->ID, '_simple_cta_popup_close', true);
                    echo $close;
            }
        }
        add_action('manage_posts_custom_column',  'simple_cta_popup_close_columns_data');
        
        add_action('rest_api_init', function () {
            register_rest_route( 'simple_cta_popup/v1', 'visited/(?P<simple_cta_popup_visited_id>\d+)',array(
                'methods'  => 'GET',
                'callback' => 'simple_cta_popup_visited'
            ));
        });
        
        function simple_cta_popup_visited($request) {
            
            $simple_cta_popup_visited_id = $request['simple_cta_popup_visited_id'];
            $simple_cta_popup_visit = get_post_meta($simple_cta_popup_visited_id, '_simple_cta_popup_visit', true);
            
            if (!$simple_cta_popup_visit) {
                update_post_meta($simple_cta_popup_visited_id, '_simple_cta_popup_visit', 1);
                update_post_meta($simple_cta_popup_visited_id, '_simple_cta_popup_click', 0);
                update_post_meta($simple_cta_popup_visited_id, '_simple_cta_popup_close', 0);
            } else {
                $simple_cta_popup_cookie = $_COOKIE["_simple_cta_popup_" . $simple_cta_popup_visited_id];
                if (!$simple_cta_popup_cookie) {
                    $simple_cta_popup_visit = $simple_cta_popup_visit + 1;
                    update_post_meta($simple_cta_popup_visited_id, '_simple_cta_popup_visit', $simple_cta_popup_visit);
                }
            }
            
            $response = new WP_REST_Response("Visited");
            $response->set_status(200);
            return $response;
        }
        
        add_action('rest_api_init', function () {
            register_rest_route( 'simple_cta_popup/v1', 'closed/(?P<simple_cta_popup_closed_id>\d+)',array(
                'methods'  => 'GET',
                'callback' => 'simple_cta_popup_closed'
            ));
        });
        
        function simple_cta_popup_closed($request) {
            
            $simple_cta_popup_closed_id = $request['simple_cta_popup_closed_id'];
            $simple_cta_popup_close_count = get_post_meta($simple_cta_popup_closed_id, '_simple_cta_popup_close', true);
            update_post_meta( $simple_cta_popup_closed_id, '_simple_cta_popup_close', $simple_cta_popup_close_count + 1 );
            
            $response = new WP_REST_Response("Closed");
            $response->set_status(200);
            return $response;
        }
        
        add_action('rest_api_init', function () {
            register_rest_route( 'simple_cta_popup/v1', 'clicked/(?P<simple_cta_popup_clicked_id>\d+)',array(
                'methods'  => 'GET',
                'callback' => 'simple_cta_popup_clicked'
            ));
        });
        
        function simple_cta_popup_clicked($request) {
            $simple_cta_popup_clicked_id = $request['simple_cta_popup_clicked_id'];
            $simple_cta_popup_click_count = get_post_meta($simple_cta_popup_clicked_id, '_simple_cta_popup_click', true);
            update_post_meta( $simple_cta_popup_clicked_id, '_simple_cta_popup_click', $simple_cta_popup_click_count + 1 );
            $response = new WP_REST_Response("Clicked");
            $response->set_status(200);
            return $response;
        }

?>