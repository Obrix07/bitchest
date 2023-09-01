<template>
    <p>test</p>
</template>

<script>
export default {
    data () {
        return {
            
        }
    },
    mounted () {
    axios
      .get('https://api.coindesk.com/v1/bpi/currentprice.json')
      .then(response => (this.info = response))
    }
}
</script>