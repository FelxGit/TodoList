<template>
<!-- The Modal -->
<div class="modal" id="updateTodoModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update TodoList </h4>
        <button type="button" @click="closeTodoModal" class="close">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="updateTodoForm">
          <div class="form-group">
              <label for="udescription">Todo Description:</label>
              <textarea required class="form-control" @change="description" :value="getDescription" name="description" id="udescription" placeholder="I want to do this.">
              </textarea>
          </div>
          <div class="checkbox">
              <label><input type="checkbox" class="" @change="active" :checked="getActive" name="active"> Active </label>
              <label><input type="checkbox" @change="completed" :checked="getCompleted" name="completed"> Completed </label>
              <label><input type="date" @change="dueDate" :value="getDueDate" name="dueDate" required> Due Date </label>
          </div><br/>
          <button type="button" class="btn btn-primary" @click="updateTodo">
            <span class="" v-if="req_status === 'pending'">loading</span>
            <span class="" v-else>Update</span>
          </button>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" @click="closeTodoModal" class="btn btn-danger">Close</button>
      </div>

    </div>
  </div>
</div>
</template>
<script>
export default {
    name: 'update-todo-modal',
    props: {
      todo: {
        type: Object,
        default: {}
      }
    },
    data() {
        return {
            udescription: '',
            uactive: 0,
            ucompleted: 0,
            due_date: '',
            req_status: ''
        }
    },
    methods: {
        updateTodo(e) {
            console.log('updateTodo')
            this.req_status = 'pending'
            console.log(this.formData)

            this.$http.put('api/todos/'+this.todo.id, this.formData)
            .then( response => {
              this.req_status = 'success'
              this.$emit('alertMessage', {'type': 'success', 'message': 'Successfully updated todo.'})
            })
            .catch( err => {
              this.req_status = 'error'
              this.$emit('alertMessage', {'type': 'danger', 'message': 'Server failed to proccess request.' })
            })
        },
        closeTodoModal(e) {
          console.log('closeTodoModal')
          $('#updateTodoModal').slideToggle()
          $('#alert-box').hide()
        },
        description(e) {
          this.udescription = e.target.value
        },
        completed(e) {
            this.ucompleted = e.target.checked
        },
        active(e) {
            console.log(e.target.value)
            this.uactive = e.target.checked
        },
        dueDate(e) {          
            console.log(e.target.value)
            this.due_date = e.target.value
        }
        
    },
    computed: {
        formData() {
          
            let description = this.getDescription
            let active = this.getActive
            let completed = this.getCompleted
            let due_date = this.getDueDate

            return {'description': description, 'active': active, 'completed': completed, 'due_date': due_date}
        },
        getDescription() {
          
          if(this.udescription === ''){
            return this.todo.description
          }else{
            return this.udescription
          }
        },
        getCompleted(){
          if(this.ucompleted === 0){
            return this.todo.completed
          }else{
            return this.ucompleted
          }
        },
        getActive(){
          if(this.uactive === 0){
            return this.todo.active
          }else{
            return this.uactive
          }
        },
        getDueDate() {
          if(this.due_date === ''){
            return this.todo.dueDate
          }else{
            return this.due_date
          }
        }
    }
}
</script>
