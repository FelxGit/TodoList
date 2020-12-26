<template>
    <div id="alert-box" :class="'alert alert-'+data.type" class="alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{ data? data.message: '' }}
    </div>
</template>
<script>

export default {
    name: 'alert-box',
    props: {
        data: {
            type: Object,
            default: () => {}
        }
    }
}

</script>

<style scoped>
    #alert-box {
        position: fixed;
        bottom: 10px;
        right: 5px;
        z-index: 99999;
        display: none
    }
</style>