const profile = {
    namespaced: true,
    state: {
        isLoggedIn: false,
        name: '',
        role_name: '',
        role_id: '',
        kecamatan_id: '',
    },
    mutations: {
        SET_PROFILE_DATA(state, payload) {
            state.isLoggedIn = payload ? true : false;
            if (payload) {
                state.role_name = payload.role_name;
                state.role_id = payload.id_role;
                state.kecamatan_id = payload.id_kecamatan;
                if (payload.id_role == process.env.MIX_ROLE_KONSELOR_ID) {
                    state.name = payload.konselor_name;
                    state.id_konselor = payload.id_konselor;
                } 
                else if (payload.id_role == process.env.MIX_ROLE_OPD_ID) {
                    state.name = payload.opd_name;
                } 
                else {
                    state.name = payload.name;                    
                }
            } 
            else {
                state.name = '';
                state.role_name = '';
                state.role_id = '';
                state.kecamatan_id = '';
            }
        }
    }
}

export default profile;
