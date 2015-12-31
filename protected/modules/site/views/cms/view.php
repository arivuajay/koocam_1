<?php
/* @var $this DefaultController */
/* @var $model Cms */

$this->title = "{$model->cms_title}";
$themeUrl = $this->themeUrl;

$cover_image = '';
if (!empty($model->cover_photo)) {
    $cover_image = 'background-image: url(' . $model->getFilePath() . ');';
}
?>

<div class="tt-fullHeight3" id="inner-banner" style = "<?php echo $cover_image; ?>">
    <div class="container homepage-txt">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-8 col-md-offset-1  col-lg-offset-2 page-details ">

                <h2><a href="#"><?php echo $model->cms_title; ?></a></h2>
                <a href="#"> <?php echo $model->cms_tag; ?> </a><br>
            </div>
        </div>
    </div>
</div>
<?php echo $content; ?>

<?php if ($model->youtube_video_url) { ?>
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
                height: '315',
                width: '553',
                videoId: '<?php echo $model->video_id ?>',
                playerVars: {'modestbranding': 1, 'autoplay': 1, 'controls': 1, 'rel': 0, 'showinfo': 0},
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

        function onPlayerError() {
            $('#player').addClass('hide');
//            $('#no-video').removeClass('hide');
        }
    </script>
<?php } ?>
