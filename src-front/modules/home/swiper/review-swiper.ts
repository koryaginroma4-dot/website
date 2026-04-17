import Swiper from "swiper";
import { Navigation, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export class ReviewSwiper {
    public constructor(
        private readonly swiperId: string,
        private readonly leftNavButtonId: string,
        private readonly rightNavBtnId: string,
    ) {
    }

    public init() {
        document.addEventListener('DOMContentLoaded', () => {
            const swiperElement = document.querySelector<HTMLElement>(this.swiperId);
            if (swiperElement === null) {
                return;
            }

            const slides = swiperElement.querySelectorAll<HTMLElement>('.swiper-slide');
            const isSingleSlide = slides.length <= 1;

            swiperElement.classList.toggle('reviews-swiper--single', isSingleSlide);

            new Swiper(this.swiperId, {
                modules: [Navigation, Pagination],
                slidesPerView: 'auto',
                spaceBetween: 20,
                loop: !isSingleSlide,
                navigation: {
                    nextEl: this.rightNavBtnId,
                    prevEl: this.leftNavButtonId,
                },
            });
        });
    }
}