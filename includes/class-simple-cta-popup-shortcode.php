<?php

        // Add CTA Shortcode
        function cta_shortcode( $atts ) {
        
            $atts = shortcode_atts(
                array(
                    'id' => '',
                ),
                $atts,
                'cta'
            );

            if ( isset( $atts['id'] ) ) {
                global $post;
                $posts = new WP_Query( array( 'post_type' => 'simple_cta_popup', 'p' => $atts['id'] ) );
                $output = '';

                if ($posts->have_posts()) {
                    while($posts->have_posts()){

                        $simple_cta_popup_visit = get_post_meta($atts['id'], '_simple_cta_popup_visit', true);
                        if (!$simple_cta_popup_visit) {
                            update_post_meta($atts['id'], '_simple_cta_popup_visit', 1);
                            update_post_meta($atts['id'], '_simple_cta_popup_view', 0);
                            update_post_meta($atts['id'], '_simple_cta_popup_click', 0);
                        } else {
                            $simple_cta_popup_visit = $simple_cta_popup_visit + 1;
                            update_post_meta($atts['id'], '_simple_cta_popup_visit', $simple_cta_popup_visit);
                        }

                        $posts->the_post();
                        $output = '
                            <div class="cta_notif_content hide" id="slider" style="transition: all 1s ease-in-out;">
                                <div class="cta_notif_data">
                                    <div class="cta_notif_headline">' . get_post_meta( get_the_ID(), '_simple_cta_popup_notification_text', true ) . '</div>
                                </div>
                                <div class="cta_notif_button open-popup-link" id="open-popup-link">' . get_post_meta( get_the_ID(), '_simple_cta_popup_notification_button', true ) . '</div>
                            </div>
                            
                            <div id="myModal" class="popup-modal">
                                <span class="popup_close">&times;</span>
                                <a href="' . get_post_meta( get_the_ID(), '_simple_cta_popup_url', true ) . '" style="display: contents;" id="popup_link"><img class="popup-modal-content" id="img01"></a>
                                <div id="caption"></div>
                            </div>
                            
                            <script>
                                var url = window.location.href;
                                var arr = url.split("/");
                                var result = arr[0] + "//" + arr[2];
                                click_api = result + "/wp-json/simple_cta_popup/v1/clicked/' . $atts['id'] . '";
                                view_api = result + "/wp-json/simple_cta_popup/v1/viewed/' . $atts['id'] . '";

                                cookieName = "_simple_cta_popup_' . $atts['id'] . '";
                                var cookieValue = getCookie(cookieName);
                                if (cookieValue != "viewed") {
                                    var img = document.createElement("img");
                                    img.src = "' . get_the_post_thumbnail_url($atts['id'], "full") . '";
                                    img.id = "myImg";
                                    
                                    var elem = document.getElementById("slider");
                                    function slide() {
                                        elem.classList.toggle("hide");
                                    }
                                    
                                    window.addEventListener("load", function () {
                                        slide();
                                    })
                                    
                                    var modal = document.getElementById("myModal");
                                    var modalImg = document.getElementById("img01");
                                    var captionText = document.getElementById("caption");
                                    var mylink = document.getElementById("open-popup-link");
                                    
                                    mylink.addEventListener("click", function () {
                                        setCookie(cookieName, "viewed")
                                        slide();
                                        modal.style.display = "block";
                                        modalImg.src = img.src;
                                        captionText.innerHTML = img.alt;
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                console.log(this.responseText);
                                            }
                                        };
                                        xhttp.open("GET", view_api, true);
                                        xhttp.send();
                                    });
                                    
                                    var mybutton = document.getElementById("popup_link");
                                    mybutton.addEventListener("click", function () {
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                console.log(this.responseText);
                                            }
                                        };
                                        xhttp.open("GET", click_api, true);
                                        xhttp.send();
                                    });

                                    modal.addEventListener("click", function () {
                                        modal.style.display = "none";
                                    }, false);

                                    var span = document.getElementsByClassName("popup_close")[0];
                                    
                                    span.onclick = function() { 
                                        modal.style.display = "none";
                                    }
                                }
                            </script>
                            <script>
                            /*
                                jQuery.ajax({
                                    url: window.location.hostname + "/wp-json/simple_cta_popup/v1/clicked/' . $atts['id'] . '",
                                    success: function(){
                                        window.location.href = "' . get_the_content() . '";
                                    }
                                });
                            */
                            </script>
                        ';
                    }
                } else {
                    return;
                }
                
                wp_reset_query();
                return html_entity_decode($output);
            }
        }
        add_shortcode( 'cta', 'cta_shortcode' );





        function simple_cta_popup_visit_columns($columns) {
            $columns['visit'] = 'نمایش پیام';
            return $columns;
        }
        add_filter('manage_posts_columns', 'simple_cta_popup_visit_columns');
        
        function scp_visit_columns_only($columns) {
            $columns['visit'] = 'نمایش پیام';
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
        



        function simple_cta_popup_view_columns($columns) {
            $columns['view'] = 'نمایش پاپ‌آپ';
            return $columns;
        }
        add_filter('manage_posts_columns', 'simple_cta_popup_view_columns');
        
        function scp_view_columns_only($columns) {
            $columns['view'] = 'نمایش پاپ‌آپ';
            return $columns;
        }
        add_filter('manage_edit-simple_cta_popup_columns', 'scp_view_columns_only');
        
        function simple_cta_popup_view_columns_data($name) {
            global $post;
            switch ($name) {
                case 'view':
                    $view = get_post_meta($post->ID, '_simple_cta_popup_view', true);
                    echo $view;
            }
        }
        add_action('manage_posts_custom_column',  'simple_cta_popup_view_columns_data');

        
        
        
        function simple_cta_popup_click_columns($columns) {
            $columns['click'] = 'کلیک';
            return $columns;
        }
        add_filter('manage_posts_columns', 'simple_cta_popup_click_columns');

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




        add_action('rest_api_init', function () {
            register_rest_route( 'simple_cta_popup/v1', 'viewed/(?P<simple_cta_popup_viewed_id>\d+)',array(
                'methods'  => 'GET',
                'callback' => 'simple_cta_popup_viewed'
            ));
        });

        function simple_cta_popup_viewed($request) {

            $simple_cta_popup_viewed_id = $request['simple_cta_popup_viewed_id'];
            $simple_cta_popup_view_count = get_post_meta($simple_cta_popup_viewed_id, '_simple_cta_popup_view', true);
            update_post_meta( $simple_cta_popup_viewed_id, '_simple_cta_popup_view', $simple_cta_popup_view_count + 1 );

            $response = new WP_REST_Response("V");
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

            $response = new WP_REST_Response("C");
            $response->set_status(200);
            return $response;
        }

?>