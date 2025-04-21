<script setup>
import {
    ref,
    reactive,
    computed,
    onMounted,
} from 'vue';
import {
    useStore
} from 'vuex';

const store = useStore();

const showAutocompleteResultsMath = ref(false);
const showAutocompleteResultsLocation = ref(false);
const starSize = ref(Array(5).fill(1));
const listOpinions = ref([1, 2, 3, 4, 5]);

const slideOpinions = ref({
    currentIndex: 0,
    itemWidth: 496,
    scaleSteps: [0.96, 0.84, 0.64, 0.36, 0],
    peekDistance: 8,
});

const dataSearch = reactive({
    subject: '',
    location: '',
});

const currentOffset = computed(() => -slideOpinions.value.currentIndex * slideOpinions.value.itemWidth);
const listSubject = computed(() => store.state.listSubject);
const listLocation = computed(() => store.state.listLocation);

onMounted(() => {
    updateSearchHeaderHeight();
});

const updateSearchHeaderHeight = () => {
    const element = document.querySelector("#mainSearch");
    if (element) {
        const containerHeight = element.getBoundingClientRect().height;
        store.dispatch('updateHeigthShowSearchHeader', containerHeight);
    }
};

const getStyleListOpinions = (index) => {
    const {
        currentIndex,
        itemWidth,
        scaleSteps,
        peekDistance
    } = slideOpinions.value;
    const distance = Math.abs(index - currentIndex);
    const maxVisible = scaleSteps.length - 1;

    if (distance > maxVisible || index > currentIndex) return {};

    if (index === currentIndex) {
        return {
            transform: `translateX(${distance * itemWidth}px) scale(0.96)`,
            zIndex: 2,
        };
    } else if (index === currentIndex - 1) {
        return {
            transform: `translateX(${distance * itemWidth - peekDistance}px) scale(0.92)`,
            zIndex: 1,
        };
    } else {
        const translateX = distance * itemWidth;
        const scale = scaleSteps[distance];
        return {
            transform: `translateX(${translateX}px) scale(${scale})`,
            zIndex: -distance,
        };
    }
};

const prevSlideOpinions = () => {
    if (slideOpinions.value.currentIndex > 0) {
        slideOpinions.value.currentIndex--;
    }
};

const nextSlideOpinions = () => {
    if (slideOpinions.value.currentIndex < listOpinions.value.length - 1) {
        slideOpinions.value.currentIndex++;
    }
};
</script>

<template>
<div class="primary-content distance-to-head">
    <div class="main-search" ref="mainSearch">
        <div class="main-search-container">
            <div class="main-search-tool">
                <div class="main-text">
                    <h1>Học<br>với những người giỏi nhất!</h1>
                </div>
                <div class="search">
                    <div class="search-form-container">
                        <div class="home-search-form autocomplete">
                            <input class="autocomplete-input" placeholder="Hãy thử 'toán học'" v-model="dataSearch.subject" @focus="showAutocompleteResultsMath = true;" @blur="showAutocompleteResultsMath = false;" />
                            <div class="home-search-results autocomplete-results" :class="{ show: showAutocompleteResultsMath }">
                                <div v-for="(subject, index) in listSubject" :key="index" class="autocomplete-result-value">
                                    <div>{{ subject.name }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="home-search-form">
                            <input class="autocomplete-input" placeholder="Địa điểm học" v-model="dataSearch.location" @focus="showAutocompleteResultsLocation = true;" @blur="showAutocompleteResultsLocation = false;" />

                            <div class="home-search-results autocomplete-results" :class="{ show: showAutocompleteResultsLocation }">
                                <div v-for="(location, index) in listLocation" :key="index" class="autocomplete-result-value">
                                    <img class="icon" :src="location.image" :alt="location.name" />
                                    <span class="name">{{ location.name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="btn-container">
                            <button class="search-header-submit">
                                <span class="text">Tìm kiếm</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="list-subject-container" :class="{ 'lower-opacity': showAutocompleteResultsLocation || showAutocompleteResultsMath }">
                    <div class="wrapper-subjects custom-scrollbar">
                        <ul>
                            <li v-for="(subject, index) in listSubject" :key="index">
                                <a class="list-item">
                                    <img class="icon" :src="subject.image" :alt="subject.name" />
                                    <span class="name">{{ subject.name }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="secondary-content">
    <div class="ads-pagination">
        <div class="title">
            <h2>
                <span>30 million reviewed tutors</span>
                <div class="list-star">
                    <img class="star-size" src="/images/star-svgrepo-com-yellow.svg" v-for="(item, index) in starSize" :key="index" />
                </div>
            </h2>
        </div>
    </div>
    <div class="teacher-list">
        <ResultsList />
    </div>
</div>

<div class="opinions">
    <div class="opinions-container">
        <div class="title-opinions">
            <div class="list-star">
                <img class="star-size" src="/images/star-svgrepo-com-yellow.svg" v-for="(item, index) in starSize" :key="index" />
            </div>
            <h2 class="title">The Perfect Match</h2>
            <h3 class="subtitle">
                <span>More than one million students gave a</span>
                <br>
                <span class="emphasis">5 star review to their tutor</span>
            </h3>
            <div class="controls">
                <span :class="['prev', { active: slideOpinions.currentIndex > 0 }]" @click="prevSlideOpinions">
                    <i class="fa-solid fa-arrow-left"></i>
                </span>
                <span :class="['next', { active: slideOpinions.currentIndex < listOpinions.length - 1 }]" @click="nextSlideOpinions">
                    <i class="fa-solid fa-arrow-right"></i>
                </span>
            </div>
        </div>
        <div class="content" :style="{ '--opinion-total': listOpinions.length }">
            <ul :style="{ transform: `translateX(${currentOffset}px)` }">
                <li v-for="(teacher, index) in listOpinions" :style="getStyleListOpinions(index)">
                    <div class="review">
                        <div class="details">
                            <div class="avatar" data-src="//c.superprof.com/i/a/20857199/10078957/160/20220602164228/biochemistry-graduate-and-professional-science-and-math-tutor-with-over-decade-tutoring-experience.jpg" style="background-image: url(&quot;//c.superprof.com/i/a/20857199/10078957/160/20220602164228/biochemistry-graduate-and-professional-science-and-math-tutor-with-over-decade-tutoring-experience.jpg&quot;);"></div>
                            <div class="infos">
                                <p class="name">Leila</p>
                                <p class="desc">Mathematics tutor</p>
                            </div>
                        </div>
                        <p class="comment">Leila was such a huge help with helping my girlfriend get ready with her practice organic biochemistry exam. Leila knows her stuff and is the real deal! 10/10 recommend !!! :D</p>
                        <div class="rating-container">
                            <div class="rating">
                                <span>Josh</span>
                                <div class="list-star">
                                    <img class="star-size" src="/images/star-svgrepo-com-yellow.svg" v-for="(item, index) in starSize" :key="index" />
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<a href="#" class="join-us">
    <img src="/images/become-teacher.webp" />
    <div class="content">
        <h2 class="title">You can become<br>a great tutor too!</h2>
        <p class="subtitle">Share your knowledge, live off your passion and become your own boss</p>
        <div class="btn-cta">
            <span class="text">Find out more</span>
            <span class="icon-container">
                <i class="fa-regular fa-star icon"></i>
            </span>
        </div>
    </div>
</a>
</template>

<style scoped>
</style>
