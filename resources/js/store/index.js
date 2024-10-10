import {createStore} from 'vuex';

import users from './modules/users.js'
import createMultiTabState from 'vuex-multi-tab-state';
import notification from './modules/notification.js'
import companies from './modules/companies.js'
import adds from './modules/adds.js'

export default createStore({
  state: {
    loading: false,
    secondary_loading: false
  },
  getters: {
    loading: (state) => (state.loading),
    secondary_loading: (state) => (state.secondary_loading)
  },
  mutations: {

    SET_LOADING: (state, value) => {
      state.loading = value;
    },

    SET_SECONDARY_LOADING: (state, value) => {
      state.secondary_loading = value;
    }
  },
  actions: {},
  modules: {
    users,
    companies,
    adds,
    notification
  },
  plugins: [createMultiTabState()]
})
