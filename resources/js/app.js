/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 */

Vue.component('tasks', require('./components/Tasks.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
    	task: null,
    	todos: [],
    	incomplete: [],
    	isActive: false
    },
    methods: {
    	submit() {
    		var formdata = new FormData();
		    formdata.append('task', this.task);
    		axios.post('/todos/store', formdata)
				.then(response => {
				  	this.task = null;
				  	return this.tasks();
				})
				.catch(error => {
				   	console.log(error);
				});
    	},

    	remove(){
    		axios.post('/todos/destroy')
				.then(response => {
				  	return this.tasks();
				})
				.catch(error => {
				   	console.log(error);
				});
    	},

    	taskCompleted(){
    		return this.tasks();
    	},

    	tasks() {
    		axios.get('/todos')
				.then(response => {
				    // handle success
				    this.todos = response.data;
				})
				.catch(error => {
				    // handle error
				    console.log(error);
				});
	    },

	    leftTasks() {
	    	axios.get('/todos/incomplete')
				.then(response => {
				    // handle success
				    this.incomplete = response.data;
				})
				.catch(error => {
				    // handle error
				    console.log(error);
				});
    	},

    	activeTasks() {
    		this.todos = this.incomplete;
    	},

    	completeTasks() {
	    	axios.get('/todos/completed')
					.then(response => {
					    // handle success
					    this.todos = response.data;
					})
					.catch(error => {
					    // handle error
					    console.log(error);
					});
		}

	   
    },
    created() {
    	return this.tasks();
    },
    mounted(){
    	return this.leftTasks()
    }
    
});
