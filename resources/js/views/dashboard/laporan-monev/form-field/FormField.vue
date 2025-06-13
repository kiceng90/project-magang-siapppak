<template>
    <label class="form-label fw-bolder fs-6 mb-3">{{ label }}</label>
    <input
        v-if="inputType === laporanMonevKuesionerInputType.TEXT.value"
        type="text"
        :value="value"
        @input="$emit('onChange', $event.target.value)"
        class="form-control mb-5"
        :name="name"
    />
    <input
        v-if="inputType === laporanMonevKuesionerInputType.FILE.value"
        type="file"
        v-on:change="$emit('onChange', $event.target.files[0])"
        class="form-control mb-5"
        :name="name"
    />
    <template v-if="inputType === laporanMonevKuesionerInputType.RADIO.value">
        <div
            class="form-check mb-5"
            v-for="(opt, i) in inputOptions"
            :key="i"
        >
            <input
                class="form-check-input"
                type="radio"
                :id="name+i"
                :value="opt.value"
                @input="$emit('onChange', $event.target.value)"
                :name="name"
                :checked="value == opt.value"
            >
            <label class="form-check-label" :for="name+i">
                {{ opt.label }}
            </label>
        </div>
    </template>

</template>

<script>
export default {
    props: ['inputType', 'inputOptions', 'value', 'label', 'name'],
    emits: ['onChange'],
    computed: {
        laporanMonevKuesionerInputType(){
            return this.$store.state.enums.laporanMonevKuesionerInputType;
        },
    },
}
</script>