<template>
    <div>
        <div class="form-group form-row" v-for="(schedule, index) in schedules">
            <div class="col-11">
                <input
                    type="text"
                    :name="`schedules[${index}][hour]`"
                    class="form-control"
                    v-model="schedule.hour"
                    placeholder="Hour (ex : 23:50)"
                />
            </div>
            <div class="col-1">
                <button
                    type="button"
                    @click="removeSchedule(index)"
                    class="btn btn-outline-danger"
                >
                    x
                </button>
            </div>
        </div>
        <div class="text-center">
            <button
                type="button"
                @click="addSchedule()"
                class="btn btn-secondary btn-sm"
            >
                Add Schedule
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        schedules: [],
    }),
    props: ['oldSchedules'],
    created(){
        this.schedules = this.oldSchedules;
    },
    methods: {
        addSchedule() {
            this.schedules.push({
                hour: "",
            });
        },
        removeSchedule(index) {
            this.schedules.splice(index, 1);
        },
    },
};
</script>
