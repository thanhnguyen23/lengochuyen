import { createStore } from 'vuex';

const store = createStore({
    state: {
        listSubject: [],
        listLocation: [],
        listTutorAds: [],
        listLevel: [],
        userData: [],
        signInData: {
            email: '',
        },
        signUpData: {
            email: '',
            first_name: '',
            last_name: '',
            otp: '',
        },
        showNotification: {
            show: false,
            message: '',
            type: 'error',
        },
        heigthShowSearchHeader: 0,
        showSearchHeader: true,
        disableHeaderBackground: false,
        showSearchHeaderSticky: false,
        showFooter: true,
    },
    mutations: {
        setUserData(state, payload) {
            state.userData = payload;
        },
        setListSubject(state, payload) {
            state.listSubject = payload;
        },
        setListLocation(state, payload) {
            state.listLocation = payload;
        },
        setListLevel(state, payload) {
            state.listLevel = payload;
        },
        setListTutorAds(state, payload) {
            state.listTutorAds = payload;
        },
        heigthShowSearchHeader(state, payload) {
            state.heigthShowSearchHeader = payload;
        },
        showNotification(state, payload) {
            state.showNotification = payload;
        },
        showSearchHeader(state, payload) {
            state.showSearchHeader = payload;
        },
        showSearchHeaderSticky(state, payload) {
            state.showSearchHeaderSticky = payload;
        },
        showFooter(state, payload) {
            state.showFooter = payload;
        },
        disableHeaderBackground(state, payload) {
            state.disableHeaderBackground = payload;
        },
        setSignInData(state, data) {
            state.signInData = { ...data };
        },
        setSignUpData(state, data) {
            state.signUpData = { ...data };
        },
        setInfomationSignUpData(state, data) {
            state.infomationSignUpData = { ...data };
        },
    },
    actions: {
        updateUserData({ commit }, payload) {
            commit('setUserData', payload);
        },
        updateListSubject({ commit }, payload) {
            commit('setListSubject', payload);
        },
        updateListLocation({ commit }, payload) {
            commit('setListLocation', payload);
        },
        updateListLevel({ commit }, payload) {
            commit('setListLevel', payload);
        },
        updateListTutorAds({ commit }, payload) {
            commit('setListTutorAds', payload);
        },
        updateHeigthShowSearchHeader({ commit }, payload) {
            commit('heigthShowSearchHeader', payload);
        },
        updateShowNotification({ commit }, payload) {
            commit('showNotification', payload);
        },
        updateShowSearchHeader({ commit }, payload) {
            commit('showSearchHeader', payload);
        },
        updateShowSearchHeaderSticky({ commit }, payload) {
            commit('showSearchHeaderSticky', payload);
        },
        updateShowFooter({ commit }, payload) {
            commit('showFooter', payload);
        },
        updateDisableHeaderBackground({ commit }, payload) {
            commit('disableHeaderBackground', payload);
        },
        updateSignInData({ commit }, data) {
            commit('setSignInData', data);
        },
        updateSignUpData({ commit }, data) {
            commit('setSignUpData', data);
        },
        updateInfomationSignUpData({ commit }, data) {
            commit('setInfomationSignUpData', data);
        },
    },
    getters: {
        userData(state) {
            return state.userData;
        },
        listSubject(state) {
            return state.listSubject;
        },
        listTutorAds(state) {
            return state.listTutorAds;
        },
        listLocation(state) {
            return state.listLocation;
        },
        listLevel(state) {
            return state.listLevel;
        },
        heigthShowSearchHeader(state) {
            return state.heigthShowSearchHeader;
        },
        showSearchHeader(state) {
            return state.showSearchHeader;
        },
        showNotification(state) {
            return state.showNotification;
        },
        showSearchHeaderSticky(state) {
            return state.showSearchHeaderSticky;
        },
        showFooter(state) {
            return state.showFooter;
        },
        disableHeaderBackground(state) {
            return state.disableHeaderBackground;
        },
        signInData(state) {
            return state.signInData
        },
        signUpData(state) {
            return state.signUpData
        },
        infomationSignUpData (state) {
            return state.infomationSignUpData
        },
    },

});

export default store;
