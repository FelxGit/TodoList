<template>
    <div class="card">
        <div class="card-header">
            <span> Todo/s</span>
            <span role="button" @click="showAddForm">ADD</span>
        </div>
        <AddTodoModal></AddTodoModal>
        <div class="card-body">
            <div id="filter">
                <label for="active">Active <br/> <input type="checkbox" id="active"></label>
                <label for="completed">Completed<br/> <input type="checkbox" id="completed" /></label>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>@</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><p class="description">I will cook fish.</p></td>
                        <td>23232323232/2/32/32</td>
                        <td>
                            <div class="status-container">
                                <div>
                                    <label for="active1">Active:<br/>
                                        <input type="radio" id="active1" class="form-control" checked disabled>
                                    </label>
                                </div>
                                <div>
                                    <label for="completed1">Completed:<br/> 
                                        <input type="radio" id="completed1" class="form-control" disabled>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="action-container">
                                <div>
                                    <button class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-arrow">U</i></button>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash">X</i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><p class="description">I will cook fish. Added textttttttt here. yessssssss/.</p></td>
                        <td>23232323232/2/32/32</td>
                        <td>
                            <div class="status-container">
                                <div>
                                    <label for="active1">Active:<br/>
                                        <input type="radio" id="active1" class="form-control" checked>
                                    </label>
                                </div>
                                <div>
                                    <label for="completed1">Completed:<br/> 
                                        <input type="radio" id="completed1" class="form-control">
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="action-container">
                                <div>
                                    <button class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-arrow">U</i></button>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-trash">X</i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import Vue from 'vue'
Vue.component('AddTodoModal', require('../components/AddTodoModal.vue').default)

export default {
    data() {
        return {
            todos: [],
            isLoggedIn: localStorage.getItem('todoList.jwt') != null,
            user: null,
            req_status: '',
            message_board: ''
        }
    },
    mounted() {
        // this.setDefaults()
    },
    methods : {
        setDefaults() {
            if (this.isLoggedIn) {
                let user = JSON.parse(localStorage.getItem('todoList.user'))
            }
        },
        showAddForm(e) {
            console.log('showAddForm')
        }
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
        color: green
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
</style>