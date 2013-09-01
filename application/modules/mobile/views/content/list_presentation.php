<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $site->header . ' ' . $site->caption ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="<?php echo base_url() ?>mobileasset/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>mobileasset/css/jquerymobile.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>mobileasset/css/jquerymobile.nativedroid.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>mobileasset/css/jquerymobile.nativedroid.light.css"  id='jQMnDTheme' />
        <link rel="stylesheet" href="<?php echo base_url() ?>mobileasset/css/jquerymobile.nativedroid.color.green.css" id='jQMnDColor' />
        <script src="<?php echo base_url() ?>mobileasset/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo base_url() ?>mobileasset/js/jquery.mobile-1.3.2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var num_presentation = <?php echo $num_presentation ?>;
                var loaded_presentation = 0;
                $("button#more_button").tap(function() {
                    loaded_presentation += 1;
                    $.get("<?php echo site_url('mobile/get_presentation') ?>/" + loaded_presentation, function(data) {
                        $("#main_content").append(data);
                    });
                    if (loaded_presentation >= num_presentation - 1)
                    {
                        $("button#more_button").hide();
                        $("#more_container").hide();
                    }
                });
                return false;
            });
        </script>
    </head>
    <body>
        <div data-role="page" id="page" data-theme="d">
            <!--Header-->
            <div data-role="header" data-tap-toggle="false" data-theme='b'>
                <a href="#left-panel" data-ajax="false"><i class='icon-ellipsis-vertical'></i></a>
                <h1 style="position: absolute;">Presentation</h1>
                <a href="#right-panel" data-ajax="false"><i class='icon-ellipsis-horizontal' style="margin-right: 10px;"></i></a>
            </div>
            <!--Panel Left-->
            <?php echo $this->load->view('panel_left'); ?>
            <!--Panel Right-->
            <?php echo modules::run('mobile/panel_right'); ?>
            <!--Content-->
            <div data-role="content">
                <form id="feed-submit">
                    <ul data-role="listview" data-inset="true" style="display: none;" id="form-submit">
                        <li>
                            <fieldset class="ui-grid-solo" data-theme="b" style="padding: 0px 7px 0px 7px;">
                                <textarea style="width: 100;border-color: #ccc;" rows="5" name="message" id="message" placeholder=" Wanna share something ?"></textarea>
                            </fieldset>
                            <fieldset class="ui-grid-a">
                                <div class="ui-block-a"><button type="reset" data-theme="a" style="background:rgb(0,0,0);">Cancel</button></div>
                                <div class="ui-block-b"><button type="submit" data-theme="a" style="background:rgb(0,0,0);">Submit</button></div>
                            </fieldset>
                        </li>
                    </ul>
                </form>
                <ul data-nativedroid-plugin='cards' id="main_content">
                    <?php foreach ($presentation as $rowpresentation): ?>
                        <li data-cards-type='text'>
                            <h2><i class="indent-right"></i> Slideshare Content</h2>
                            <?php
                            $media = analyze_media($rowpresentation->file);
                            $extract_id = explode('^^^', $media);
                            $url = $extract_id[1];
                            $thumb = explode("/", slideshare_cover($url)->thumbnail);
                            $thumbnail = slideshare_cover($url)->thumbnail;
                            ?>
                            <a href="javascript:void(0)">
                                <img src="<?php echo "http:" . $thumbnail ?>" style="width: 100%;border-right: 1px solid white;">
                            </a>
                            <p><?php echo $rowpresentation->title ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <fieldset class="ui-grid-solo" style="padding: 0px 7px 0px 7px;" id="more_container">
                <button id="more_button" data-theme="a" style="background:rgb(0,0,0);border: 2px solid rgb(153,204,0);">Load More</button>
            </fieldset>
        </div>
        <script src="<?php echo base_url() ?>mobileasset/js/nativedroid.script.js"></script>
        <script type="text/javascript">
            $(document).on("pageinit", "#page", function() {
                //name
                $('#user_name').load("<?php echo site_url('mobile/get_name') ?>");
                //swipe left and rights
                $(document).on("swipeleft swiperight", "#page", function(e) {
                    if ($.mobile.activePage.jqmData("panel") !== "open") {
                        if (e.type === "swipeleft") {
                            $("#right-panel").panel("open");
                        } else if (e.type === "swiperight") {
                            $("#left-panel").panel("open");
                        }
                    }
                });
            });
        </script>
    </body>
</html>