// centralized alert management

export const AlertStore = 
{
   namespaced: true,
   state: 
   {
        type: null,
        message: null,
   },
   mutations: 
   {
       ALERT_SUCCESS: (state, message) => 
       {
            state.type = 'alert-success';
            state.message = message;
       },
       ALERT_ERROR: (state, message) => 
       {
            state.type = 'alert-danger';
            state.message = message;
       },
       ALERT_CLEAR: (state) => 
       {
            state.type = null;
            state.message = null;
       },
       
   },
   actions: 
   {
       alertSucces: ({commit}, message) => 
       {
            commit('ALERT_SUCCESS', message);
       },
       alertError: ({commit}, message) => 
       {
            commit('ALERT_ERROR', message);
       },
       alertClear: ({commit}) => 
       {
            commit('ALERT_CLEAR');
       },
      
   },
   getters: 
   {
      
   }
}