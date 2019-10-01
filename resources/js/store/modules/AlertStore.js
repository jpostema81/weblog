// centralized alert management

import { ALERT_SUCCESS, ALERT_ERROR, ALERT_CLEAR } from '../mutation_types';

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
       [ALERT_SUCCESS]: (state, message) => 
       {
            state.type = 'alert-success';
            state.message = message;
       },
       [ALERT_ERROR]: (state, message) => 
       {
            state.type = 'alert-danger';
            state.message = message;
       },
       [ALERT_CLEAR]: (state) => 
       {
            state.type = null;
            state.message = null;
       },
       
   },
   actions: 
   {
       [ALERT_SUCCESS]: ({commit}, message) => 
       {
            commit([ALERT_SUCCESS], message);
       },
       [ALERT_ERROR]: ({commit}, message) => 
       {
            commit([ALERT_ERROR], message);
       },
       [ALERT_CLEAR]: ({commit}) => 
       {
            commit([ALERT_CLEAR]);
       },
      
   },
   getters: 
   {
      
   }
}