export const datacardMixin = {
    methods: {
        customLabel({key, value}) {
            return `${key}: ${value}`;
        },
    },
}