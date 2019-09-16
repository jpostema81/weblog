export const CategoryStore = {
    namespaced: true,
    state: {
        categories: [],
        selectedCategories: [],
    },
    mutations: { 
        setCategories(state, categories) {
            state.categories = categories;
        },
        setSelectedCategories(state, selectedCategories) {
            state.selectedCategories = selectedCategories;
        }
    },
    actions: {
        fetchCategories({state, commit, rootState}) {
            return new Promise((resolve, reject) => {
                axios
                    .get('/api/categories')
                    .then(categories => {
                        commit('setCategories', categories.data);
                        //context.commit('setSelectedCategories', categories.data);
                        resolve();
                    }, error => {
                        reject();
                    });
            });
        }
    },
    getters: {
        categories:  (state, commit, rootState) => {
            return state.categories;
        }
    }
}