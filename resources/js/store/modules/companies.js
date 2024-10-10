export default {
  state: {
    companies: [],
    user_list: [],
    companies_list: [],
  },
  getters: {
    companies: s => s.companies,
    getCompanyById: (state) => (id) => {
      return state.companies.find(u => u.id === id)
    },
    userList: s => s.user_list,
    companiesList: s => s.companies_list
  },
  mutations: {
    saveCompanies(state, companies) {
      state.companies = companies;
    },

    pushCompany(state, company) {
      state.companies.push(company);
    },

    deleteCompany(state, data) {
      const index = state.companies.findIndex(u => u.id === data.id);
      if (index !== -1) {
        state.companies.splice(index, 1);
      }
    },

    replaceCompany(state, data) {
      const index = state.companies.findIndex(u => u.id === data.id);
      if (index !== -1) {
        state.companies.splice(index, 1, data);
      }
    },

    saveUserList(state, data) {
      state.user_list = data;
    },

    saveCompaniesList(state, data) {
      state.companies_list = data;
    }
  },
  actions: {
    saveCompanies({ commit }, companies) {
      commit('saveCompanies', companies)
    },

    pushCompany( { commit }, company) {
      commit('pushCompany', company);
    },

    deleteCompanyById( { commit }, data) {
      commit('deleteCompany', data);
    },

    replaceCompany( { commit }, data) {
      commit('replaceCompany', data);
    },

    saveUserList ({ commit }, data) {
      commit('saveUserList', data);
    },

    saveCompaniesList( { commit }, data ) {
      commit('saveCompaniesList', data);
    }
  },
  modules: {}
}

