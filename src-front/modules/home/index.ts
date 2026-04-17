// import './../common/map/map';
import { ReviewSwiper } from "./swiper/review-swiper";

const REVIEW_SWIPER_ID = '.reviews-swiper';
const REVIEW_SWIPER_LEFT_BTN_ID = '.reviews-swiper-nav__left-btn'
const REVIEW_SWIPER_RIGHT_BTN_ID = '.reviews-swiper-nav__right-btn'

// Initializing all home page classes
if (document.querySelector(REVIEW_SWIPER_ID) !== null) {
    new ReviewSwiper(
        REVIEW_SWIPER_ID,
        REVIEW_SWIPER_LEFT_BTN_ID,
        REVIEW_SWIPER_RIGHT_BTN_ID
    ).init();
}
