  
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
    error: {
        active: true,
        message: '',
    }
}

const actions = {
    showError: ({ commit }) => {
        console.log('adfadf');
    },
}

export default new Vuex.Store({
    state,
})