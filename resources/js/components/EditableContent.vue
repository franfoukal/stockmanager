<template>
  <td contenteditable="contenteditable" @input="updateInput">
      {{ content }}
  </td>
</template>

<script>
  export default {
      prop: ['value'],
      data () {
          return { content: '' }
      },
      methods: {
        updateInput () {
            this.$emit('input', this.$el.innerText)
        }
      }
  }
</script>