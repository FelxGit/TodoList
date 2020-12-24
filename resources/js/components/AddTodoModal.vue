<template>
<!-- The Modal -->
<div class="modal" id="addTodoModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add TodoList </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form id="addTodoForm">
          <div class="form-group">
              <label for="description">Todo Description:</label>
              <textarea class="form-control" v-model="description" id="description" placeholder="I want to do this.">
              </textarea>
          </div>
          <div class="checkbox">
              <label><input type="checkbox"> Active </label>
              <label><input type="checkbox"> Completed </label>
          </div>
          <button type="submit" class="btn btn-primary" @click.once="emitData">Create</button>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
            form_data: [],
            description: '',
            active: false,
            completed: false
        }
    },
    methods: {
        emitData(e) {
            this.form_data = this.formData
        },
        cleanForm() {
            console.log('cleanform')

            this.form_data = []
            this.description = ''
            this.active = false
            this.completed = false
        },
        // computed: {
        //     formData() {
        //         let description = this.description
        //         let active = this.active
        //         let completed = this.completed

        //         return {
        //             'description': description,
        //             'active': active,
        //             'completed': completed
        //         }
        //     }
        // }
    }

}
</script>
