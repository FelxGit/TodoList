<template>
<!-- Modal -->
<div class="modal" id="confirmRemoveModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="exampleModalCenterTitle">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header bg-danger">
        <h5 class="modal-title" id="exampleModalLongTitle">Remove Todo</h5>
        <button type="button" @click="closeModal" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body bg-dark text-white">
        Confirm delete todo({{ todo.description }})
    </div>
    <div class="modal-footer bg-dark">
        <button type="button" @click="closeModal" class="btn btn-secondary">Close</button>
        <button type="button" @click="confirm" class="btn btn-danger">Confirm</button>
    </div>
    </div>
</div>
</div>
</template>
<script>
export default {
    data() {
        return {
        }
    },
    props: {
        todo: {
            type: Object,
            default: {}
        }
    },
    methods: {
        confirm(e) {
            console.log('confirm')
            $('#confirmRemoveModal').slideToggle()
            this.$emit('confirm')
        },
        closeModal(e) {
            console.log('close')
            $('#confirmRemoveModal').slideToggle()


        }
    }
}
</script>
<style scoped>
    .modal-footer {
        border-top: none
    }
</style>