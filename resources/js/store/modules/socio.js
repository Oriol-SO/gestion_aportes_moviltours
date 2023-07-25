import axios from 'axios'


export const state = {
    veiculos:[],
    infoveiculo:{},
}  

export const getters = {
    veiculos:state=>state.veiculos,
    infoveiculo:state=>state.infoveiculo,
}

export const actions = {
    getVeiculos({commit}){
        axios.get('/api/get-veiculos').then(response=>{
            commit('setVeiculo',response.data)
        }).catch(e=>{
            commit('setVeiculo',response.data)
        })
    },

    getinfoveiculo({commit},veiculo){
       if(veiculo){
            axios.get('/api/get-info-veiculo/'+veiculo.id).then(response=>{
                commit('setinfoVeiculo',response.data)
            }).catch(e=>{
                commit('setinfoVeiculo',null)
            })
       }
    }
}
export const mutations={
    setVeiculo(state,data){
        state.veiculos=data;
    },
    setinfoVeiculo(state,data){
        state.infoveiculo=data;
    }
}