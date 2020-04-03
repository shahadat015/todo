<template>
    <div>
        <div class="border-bottom border-light" v-if="completed">
            <div class="form-group pl-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" :id="todo.id" @click="markComplete(todo.id)">
                  <label class="custom-control-label" :for="todo.id"></label>
                  <span v-if="!editing" @dblclick="edit" class="custom-control-span">{{ task }}</span>
                  <input v-if="editing" v-model="value" class="form-control editable-input" @keyup.enter="update(todo.id)"/>
                </div>
            </div>
        </div>
        <div class="border-bottom border-light" v-else>
            <div class="form-group pl-2">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" :id="todo.id" checked disabled>
                  <label class="custom-control-label" :for="todo.id"></label>
                  <span class="custom-control-span"><del class="complete-item">{{ task }}</del></span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['todo'],
        data() {
            return {
                task: this.todo.task,
                value: null,
                editing: false
            }
        },
        computed: {
            completed() {
                return !this.todo.completed_at;
            }
        },
        methods: {
            edit() {
                this.value = this.task;
                this.editing = true;
            },
            update(id) {
                // However we want to save it to the database
                this.task = this.value;
                this.editing = false;
                var formdata = new FormData();
                formdata.append('task', this.value);
                axios.post('/todos/'+ id +'/update', formdata)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            markComplete(id) {
                var formdata = new FormData();
                formdata.append('task', this.value);
                axios.post('/todos/'+ id +'/complete')
                    .then(response => {
                        // console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                this.$emit('done');
            }
        }
    }
</script>
