export const CategoryStore = {
    namespaced: true,
    state: {
        categories: [],
        selectedCategories: []
    },
    mutations: { 
        setCategories(state, categories) {
            state.categories = categories;
        },
        updateSelectedCategories(state, selectedCategories) {
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
                    }).catch(function (error) {
                        // handle error
                        console.log(error);
                        reject(error);
                    });
            });
        },
    },
    getters: {
        getSelectedCategoryIds: (state) => 
        {
            return state.selectedCategories.map(value => value.id).join(',');
        },
    }
}