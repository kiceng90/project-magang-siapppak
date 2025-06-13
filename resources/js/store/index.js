import complaintStore from "@/store/complaint.js";
import profileStore from "@/store/profile.js";
import clientStore from "@/store/client.js";
import enumsStore from "@/store/enums.js";

import {
    createStore
} from 'vuex'

const store = createStore({
    modules: {
        profile: profileStore,
        complaint: complaintStore,
        client: clientStore,
        enums: enumsStore
    }
})

export default store;
