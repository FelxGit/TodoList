<template>
<!-- The Modal -->
<div class="modal" id="addTodoModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add TodoList </h4>
        <button type="button" @click="closeTodoModal" class="close">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="addTodoForm">
          <div class="form-group">
              <label for="description">Todo Description:</label>
              <textarea required class="form-control" v-model="description" name="description" id="description" placeholder="I want to do this.">
              </textarea>
          </div>
          <div class="checkbox">
              <label><input type="checkbox" v-model="active" name="active"> Active </label>
              <label><input type="date" v-model="due_date" name="dueDate" autocomplete="off" required> Due Date </label>
          </div><br/>
          <button type="button" class="btn btn-primary" @click="addTodo">
            <span class="" v-if="req_status === 'pending'">loading</span>
            <span class="" v-else>Create</span>
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
    name: 'add-todo-modal',
    data() {
        return {
            description: '',
            active: false,
            due_date: '',
            req_status: ''
        }
    },
    methods: {
        addTodo(e) {
            console.log('addTodo')
            this.req_status = 'pending'

            this.$http.post('api/todos', this.formData)
            .then( response => {
              this.req_status = 'success'
              this.$emit('alertMessage', {'type': 'success', 'message': 'Successfully added todo.'})
            })
            .catch( err => {
              this.req_status = 'error'
              this.$emit('alertMessage', {'type': 'danger', 'message': 'Server failed to proccess request.' })
            })
        },
        cleanForm() {
            console.log('cleanform')
            this.form_data = {}
            this.description = ''
            this.active = false
        },
        closeTodoModal(e) {
          console.log('closeTodoModal')
          $('#addTodoModal').slideToggle()
          $('#alert-box').hide()
        },
    },
    computed: {
        formData() {
          
            let description = this.description
            let active = this.active
            let due_date = this.due_date

            return {'description': description, 'active': active, 'due_date': due_date}
        }
    }
}
</script>
