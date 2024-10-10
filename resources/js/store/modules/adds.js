export default {
  state: {
    adds: [],
  },
  getters: {
    adds: s => s.adds,

    getAddById: (state) => (id) => {
      return state.adds.find(u => u.id === id)
    },

  },
  mutations: {
    saveAdds(state, adds) {
      state.adds = adds;
    },

    pushAdd(state, adds) {
      state.adds.push(adds);
    },

    deleteAdd(state, data) {
      const index = state.adds.findIndex(u => u.id === data.id);
      if (index !== -1) {
        state.adds.splice(index, 1);
      }
    },

    replaceAdd(state, data) {
      const index = state.adds.findIndex(u => u.id === data.id);
      if (index !== -1) {
        state.adds.splice(index, 1, data);
      }
    },

    saveUserList(state, data) {
      state.user_list = data;
    }
  },
  actions: {
    saveAdds({ commit }, adds) {
      commit('saveAdds', adds)
    },

    pushAdd( { commit }, add) {
      commit('pushAdd', add);
    },

    deleteAddById( { commit }, data) {
      commit('deleteAdd', data);
    },

    replaceAdd( { commit }, data) {
      commit('replaceAdd', data);
    }
  },
  modules: {}
}

