<template>
    <div class="card">
        <AlertBox :data="alert_data"></AlertBox>
        <AddTodoModal @alertMessage="alertBox"></AddTodoModal>
        <UpdateTodoModal @alertMessage="alertBox" :todo="todo"></UpdateTodoModal>
        <ConfirmBox :todo="todo" @confirm="removeTodo(todo.id)"></ConfirmBox>

        <div class="card-header">
            <span> Todo/s</span>
            <span role="button" @click="showAddForm">ADD</span>
        </div>
        <div class="card-body">
            <div id="filter">
                <!-- add class p-default -->
                <div class="pretty p-default">
                    <input type="checkbox" v-model="active" @change="getTodos"/>
                    <div class="state p-primary">
                        <label>Active</label>
                    </div>
                </div>

                <!-- add class p-fill -->
                <div class="pretty p-default p-fill">
                    <input type="checkbox" v-model="completed" @change="getTodos"/>
                    <div class="state p-primary">
                        <label>Completed</label>
                    </div>
                </div>
                 <div class="pretty p-switch">
                    <input type="checkbox" v-model="hard_filter" @change="getTodos"/>
                    <div class="state p-danger">
                        <label>Enable hard filter</label>
                    </div>
                </div>
            </div><br/>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>@</th>
                        <th>Description</th>
                        <th>Due/Completed</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tr v-for="(todo, index) in todos.data" :key="index">
                        <td>{{ (todos.from-1)+(index+1) }}</td>
                        <td><p class="description">{{ todo.description }}</p></td>
                        <td>{{ todo.due }} -> {{ todo.dateCompleted }}</td>
                        <td>
                            <div class="status-container">
                                <div>
                                    <label for="active">Active:<br/>
                                        <input type="radio" id="active" class="form-control" :checked="todo.active===1" disabled>
                                    </label>
                                </div>
                                <div>
                                    <label for="completed">Completed:<br/> 
                                        <input type="radio" id="completed" class="form-control" :checked="todo.completed===1" disabled>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="action-container">
                                <div>
                                    <button @click="showUpdateForm(todo)" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-arrow">U</i></button>
                                </div>
                                <div>
                                    <button @click="showConfirmRemove(todo)" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash">X</i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <pagination :data="todos" @pagination-change-page="getTodos"></pagination>
            </div>
        </div>
    </div>
</template>
<script>
import Vue from 'vue'
Vue.component('AddTodoModal', require('../components/AddTodoModal.vue').default)
Vue.component('UpdateTodoModal', require('../components/UpdateTodoModal.vue').default)
Vue.component('AlertBox', require('../components/AlertBox.vue').default)
Vue.component('ConfirmBox', require('../components/ConfirmBox.vue').default)
Vue.component('pagination', require('laravel-vue-pagination'))

export default {
    data() {
        return {
            todos: {},
            isLoggedIn: localStorage.getItem('todoList.jwt') != null,
            user: null,
            req_status: '',
            alert_data: {},
            current_page: 1,
            active: false,
            completed: false,
            hard_filter: false,
            todo: {}
        }
    },
    mounted() {
        this.setDefaults()
        this.refreshTodo()
    },
    methods : {
        setDefaults() {
            if (this.isLoggedIn) {
                let user = JSON.parse(localStorage.getItem('todoList.user'))
            }
        },
        showAddForm(e) {
            console.log('showaddform')

            try{
            this.current_page = this.todos.current_page
            }catch(e){}

            this.cleanAddTodoForm()
            $('#addTodoModal').slideToggle()
        },
        cleanAddTodoForm() {
           const form = document.querySelector('#addTodoForm')
           form.reset()
        },
        showConfirmRemove(todo) {
            console.log('showConfirmRemove')
            this.todo = todo
            $('#confirmRemoveModal').slideToggle()
        },
        removeTodo(todo_id) {
            console.log('removeTodo')
            this.req_status = 'PENDING'

            this.$http.delete('api/todos/' +todo_id)
            .then( response => {

                this.alertBox({'type': 'success', 'message': 'Delete success.'})
                this.req_status = 'SUCCESS'
            })
            .catch( err=>{
                this.req_status = 'ERROR'
            })
        },
        alertBox(data) {
            console.log('alertbox')
            
            $('#alert-box').show()
            this.alert_data = data

            if(data.type === 'success'){
                this.refreshTodo()
            }
        },
        refreshTodo() {
           this.getTodos(this.current_page)
        },
        getTodos(page=1) {
            this.req_status = 'pending'
            this.current_page = page

            let active = this.active
            let completed = this.completed
            let hard_filter = this.hard_filter  

            this.$http.get('api/todos?page=' + page + '&active=' + active + '&completed=' + completed + '&hard_filter=' + hard_filter)
            .then( response => {
                this.todos = response.data
                this.req_status = 'success'
                this.setDefaults()
            })
            .catch( err => {
                this.req_status = 'error'
            })

        },
        showUpdateForm(todo) {
            console.log('showUpdateForm')
            try{
            this.current_page = this.todos.current_page
            }catch(e){}
            
            $('#updateTodoModal').slideToggle()
            this.todo = todo
        },
        cleanUpdateTodoForm() {
           const form = document.querySelector('#updateTodoForm')
           form.reset()
        },

    },
    computed: {
    }
}
</script>
<style scoped>
    .card-header > span[role="button"]{
        float: right;
        color: blue;
        margin: auto;    
    }
    #filter {
        font-size: 12px;
    }
    .card-header input[type='checkbox'] {
        width: 15px;
    }
    .description {
        min-width: 200px;
    }
    .status-container input[type='radio'] {
        width: 15px;
        height: 15px;
    }
    .status-container {
        display: grid;
        grid-template-columns: auto auto;
        grid-column-gap: 10px;
        font-size: 10px;
    }
    .action-container {
        display: grid;
        grid-template-columns: auto auto;
        grid-column-gap: 5px;
    }
    .checked-radio {
        background-color: green;
        border: thin solid green;
        color: green;
    }
    @media screen and (max-width: 500px){
        #filter > div{
            margin-top: 20px;
        }
    }

</style>