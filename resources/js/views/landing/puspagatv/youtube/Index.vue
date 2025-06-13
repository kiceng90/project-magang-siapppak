<template>
    <div>
        <div class="pu_site_page">
            <app-header></app-header>

            <section>
                <br><br><br><br>
            </section>

            <section class="pu_causes_details_part" style="padding-bottom: 50px;">
                <div class="container container_costom">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="">
                                <div class="causes_details_inner">
                                    <div class="pu_causes_details_content">
                                        <h1 class="title fw-bold text-center">
                                            Puspaga TV
                                        </h1>
                                        <div class="carousel-inner" width="100%" height="525">
                                            <!-- Main video iframe -->
                                            <div id="main-video" class="video-frame"></div>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <br><br>
                                            <!-- Other video section 1 (Kelas Parenting) -->
                                            <div class="col-md-6">
                                                <h2 style="font-size: 24px; font-weight: bold;">Kelas Parenting</h2>
                                                <div class="carousel-inner" width="100%" height="525">
                                                    <br>
                                                    <div id="video-parenting" class="video-frame"></div>
                                                </div>
                                            </div>
                                            <!-- Other video section 2 (Belajar Bareng Puspaga) -->
                                            <div class="col-md-6">
                                                <h2 style="font-size: 24px; font-weight: bold;">Belajar Bareng Puspaga</h2>
                                                <div class="carousel-inner" width="100%" height="525">
                                                    <br>
                                                    <div id="video-belajar" class="video-frame"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <br><br>
                                            <!-- Other video section 3 (Webinar) -->
                                            <div class="col-md-6">
                                                <h2 style="font-size: 24px; font-weight: bold;">Webinar</h2>
                                                <div class="carousel-inner" width="100%" height="525">
                                                    <br>
                                                    <div id="video-webinar" class="video-frame"></div>
                                                </div>
                                            </div>
                                            <!-- Other video section 4 (Talkshow) -->
                                            <div class="col-md-6">
                                                <h2 style="font-size: 24px; font-weight: bold;">Talkshow</h2>
                                                <div class="carousel-inner" width="100%" height="525">
                                                    <br>
                                                    <div id="video-talkshow" class="video-frame"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <app-footer></app-footer>
        </div>

        <app-popupsearch></app-popupsearch>
        <app-mobilemenu></app-mobilemenu>
    </div>
</template>

<script>
export default {
    data() {
        return {
            players: []
        };
    },
    mounted() {
        // Load the YouTube API script dynamically
        const tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        const firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        
        // Initialize the YouTube players once the API is ready
        window.onYouTubeIframeAPIReady = () => {
            this.initializePlayers();
        };
    },
    methods: {
        initializePlayers() {
            // Main video player
            this.players.push(new YT.Player('main-video', {
                videoId: 'BujPmY-g6I4',
                playerVars: {
                    autoplay: 1,
                    controls: 1,
                    rel: 0,
                },
            }));

            // Kelas Parenting video player
            this.players.push(new YT.Player('video-parenting', {
                playerVars: {
                    listType: 'playlist',
                    list: 'PLsZgOCLlRp-ZFDN97SQX78CcCQiWc8vsL',
                    autoplay: 0,
                    controls: 1,
                    rel: 0,
                },
                events: {
                    'onStateChange': this.onPlayerStateChange
                }
            }));

            // Belajar Bareng Puspaga video player
            this.players.push(new YT.Player('video-belajar', {
                playerVars: {
                    listType: 'playlist',
                    list: 'PLsZgOCLlRp-YBA7mthwvcbhC8f-x53-_x',
                    autoplay: 0,
                    controls: 1,
                    rel: 0,
                },
                events: {
                    'onStateChange': this.onPlayerStateChange
                }
            }));

            // Webinar video player
            this.players.push(new YT.Player('video-webinar', {
                playerVars: {
                    listType: 'playlist',
                    list: 'PLsZgOCLlRp-YVues_jqhN9BFueb-ffZAt',
                    autoplay: 0,
                    controls: 1,
                    rel: 0,
                },
                events: {
                    'onStateChange': this.onPlayerStateChange
                }
            }));

            // Talkshow video player
            this.players.push(new YT.Player('video-talkshow', {
                playerVars: {
                    listType: 'playlist',
                    list: 'PLsZgOCLlRp-aV4Z43qK0Z40BAxCyVU7pV',
                    autoplay: 0,
                    controls: 1,
                    rel: 0,
                },
                events: {
                    'onStateChange': this.onPlayerStateChange
                }
            }));
        },
        onPlayerStateChange(event) {
            if (event.data === YT.PlayerState.PLAYING) {
                // Pause all other videos except the one that is currently playing
                this.pauseOtherVideos(event.target);
            }
        },
        pauseOtherVideos(currentPlayer) {
            this.players.forEach((player) => {
                // Ensure that only videos other than the clicked one are paused
                if (player !== currentPlayer) {
                    const state = player.getPlayerState();
                    // Pause only if the video is currently playing
                    if (state === YT.PlayerState.PLAYING || state === YT.PlayerState.BUFFERING) {
                        player.pauseVideo();
                    }
                }
            });
        }
    }
};
</script>



<style>
.video-frame {
    width: 100%;
    height: 525px;
}
</style>

