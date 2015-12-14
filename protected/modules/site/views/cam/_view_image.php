<?php
/* @var $this DefaultController */
/* @var $model Cam */

$defaultImage = $model->camimage;
?>
<div class="course-img">
    <div class="price-bg"> <?php echo $model->cam_duration; ?> min<br/>
        <b class="cam_price_txt"> $ <?php echo $cam_price = (int) $model->cam_price; ?> </b>
    </div>
    <?php echo $model->tutor->userstatusicon; ?>
    <?php
    if ($model->is_video == 'N') {
        echo $defaultImage;
    } else {
        echo '<div id="player" class="youtube-player"></div>';
        echo "<div id='no-video' class='hide'>{$defaultImage}</div>";
    }
    ?>
</div>

<?php
if ($model->is_video == 'Y') {
    ?>
    <script>
        // 2. This code loads the IFrame Player API code asynchronously.
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // 3. This function creates an <iframe> (and YouTube player)
        //    after the API code downloads.
        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '440',
                width: '553',
                videoId: '<?php echo $model->video_id?>',
                playerVars: {'modestbranding': 1, 'autoplay': 1, 'controls': 0, 'rel': 0, 'showinfo': 0},
                events: {
                    'onReady': onPlayerReady,
//                    'onStateChange': onPlayerStateChange,
                    'onError': onPlayerError,
                }
            });
        }

        // 4. The API will call this function when the video player is ready.
        function onPlayerReady(event) {
            event.target.setVolume(100);
            event.target.playVideo();
        }

        // 5. The API calls this function when the player's state changes.
        //    The function indicates that when playing a video (state=1),
        //    the player should play for six seconds and then stop.
        var done = false;
        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING && !done) {
                setTimeout(stopVideo, 6000);
                done = true;
            }
        }
        function stopVideo() {
            player.stopVideo();
        }
        
        function onPlayerError(){
            $('#player').addClass('hide');
            $('#no-video').removeClass('hide');
        }
    </script>
<?php } ?>