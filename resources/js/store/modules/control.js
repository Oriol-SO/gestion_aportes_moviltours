import axios from 'axios'


export const state = {
    veiculos:[],
}  

export const getters = {
    veiculos:state=>state.veiculos,
}

export const actions = {
    getVeiculos({commit}){
        axios.get('/api/get-veiculos-aportes').then(response=>{
            commit('setVeiculo',response.data)
        }).catch(e=>{
            commit('setVeiculo',response.data)
        })
    },
}
export const mutations={
    setVeiculo(state,data){
        state.veiculos=data;
    },
}