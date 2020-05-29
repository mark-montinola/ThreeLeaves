<template>
  <div>
    <b-carousel
      id="carousel-1"
      no-animation
      v-model="slide"
      :interval="0"
      controls
      indicators
      background="#ababab"
      img-width="1024"
      img-height="480"
      @sliding-start="onSlideStart"
      @sliding-end="onSlideEnd"
    >
        <!-- Text slides with image -->
        <b-carousel-slide
            id="carousel-slide-1"
            caption="First slide"        
            img-src="./img/slide-1.jpg"
        ></b-carousel-slide>

        <!-- Slides with custom text -->
        <b-carousel-slide 
            id="carousel-slide-2"
            img-src="./img/slide-2.jpg">
            <!-- <h2 class="caption-title-1">New Drink, New Day!</h2> -->
            <h2 class="caption-title-1 animated infinite bounce delay-2s">New Drink, New Day!</h2>
            <h5 class="caption-title-2">
                With our wide variety of smoothies and healthy drinks, we are sure 
                <br>to help you make the right choice to start your day.
            </h5>
            <div class="button-wrap fadeInUp animated" data-caption-animate="fadeInUp" data-caption-delay="400">
                <a class="button button-lg button-shadow-4 button-secondary-2 button-zakaria" href="grid-shop.html">Shop now</a>
            </div>
        </b-carousel-slide>

    </b-carousel>

    <p class="mt-4">
        Slide #: {{ slide }}
        <br />
        Sliding: {{ sliding }}
    </p>
  </div>
</template>

<script>
export default {
    data() {
        return {
            slide: 0,
            sliding: null
        };
    },
    methods: {
        onSlideStart(slide) {
            this.sliding = true;
        },
        onSlideEnd(slide) {
            this.sliding = false;
        }
    }
};
</script>

<style>
    #carousel-slide-1, #carousel-slide-2 {
        height: 500px;
    }
    #carousel-slide-1 img, #carousel-slide-2 img {
        height: 500px;
        object-position: 52% -1px;
        object-fit: cover;
    }
    #carousel-slide-2 .carousel-caption {
        bottom: 22%;
    }
    #carousel-slide-2 .carousel-caption .caption-title-1 {
        margin-bottom: 20px;
        /* font-size: 22px; */
    }
    #carousel-slide-2 .carousel-caption .caption-title-2 {
        font-weight: 400;
        margin-bottom: 50px;
        /* font-size: 18px; */
    }
    @media (min-width: 768px) {
        #carousel-slide-1, #carousel-slide-2 {
            height: 500px;
        }
        #carousel-slide-1 img, #carousel-slide-2 img {
            height: 500px;
            object-position: 53%;
            object-fit: cover;
        }
        /* #carousel-slide-2 .carousel-caption .caption-title-1 {
            margin-bottom: unset;
            font-size: unset;
        }
        #carousel-slide-2 .carousel-caption .caption-title-2 {
            margin-bottom: unset;
            font-size: unset;
        } */
    }
    @media (min-width: 996px) {
        #carousel-slide-1, #carousel-slide-2 {
            height: unset;
        }
        #carousel-slide-1 img, #carousel-slide-2 img {
            height: unset;
            object-position: unset;
            object-fit: unset;
        }
        #carousel-slide-2 .carousel-caption {
            bottom: 30%;
        }
    }
    
</style>

<style scoped>
    h2 {
        font-size: 26px;
    }

    @media (min-width: 768px) {
        h2 {
            font-size: 35px;
        }
    }

    @media (min-width: 992px) {
        h2 {
            font-size: 45px;
        }
    }

    @media (min-width: 1200px) {
        h2 {
            font-size: 55px;
        }
    }

    /* Button */
    .button {
        position: relative;
        overflow: hidden;
        display: inline-block;
        padding: 4px 17px;
        font-size: 14px;
        line-height: 2;
        border: 2px solid;
        border-radius: 6px;
        font-family: poppins,-apple-system,BlinkMacSystemFont,segoe ui,Roboto,helvetica neue,Arial,sans-serif;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        white-space: nowrap;
        text-overflow: ellipsis;
        text-align: center;
        cursor: pointer;
        vertical-align: middle;
        user-select: none;
        transition: all 250ms ease-in-out;
    }

    @media (min-width: 768px) {
        .button {
            padding: 9px 29px;
        }
    }

    @media (min-width: 992px) {
        .button {
            padding: 14px 34px;
        }
    }

    .button-secondary-2, .button-secondary-2:focus {
        color: #151515;
        background-color: #f9e95e;
        border-color: #f9e95e;
    }

    .button-shadow-4 {
        box-shadow: 2px 3px 10px 0 rgba(0,0,0,.17);
    }

    .button-zakaria {
        transition: all .3s ease-in-out;
        z-index: 1;
    }

    .button-lg {
        padding: 9px 25px;
        font-size: 14px;
        line-height: 2;
    }

    @media (min-width: 768px) {
        .button-lg {
            padding: 14px 45px;
        }
    }

    @media (min-width: 992px) {
        .button-lg {
            padding: 19px 50px;
        }
    }

    .animated {
        -webkit-animation-duration: .7s;
        animation-duration: .7s;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
        opacity: 1;
    }

    .fadeInUp {
        -webkit-animation-name: fadeInUp;
        animation-name: fadeInUp;
    }

    @media (min-width: 992px) {
        #carousel-slide-2 *+.button-wrap, #carousel-slide-2 *+.button {
            margin-top: 40px;
        }
    }

    @media (min-width: 1200px) {
        #carousel-slide-2 *+.button-wrap, #carousel-slide-2 *+.button {
            margin-top: 50px;
        }
    }

    

    

    





</style>

