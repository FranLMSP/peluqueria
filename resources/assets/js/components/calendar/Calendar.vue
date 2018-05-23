<template>
	<div>
		{{ today }}
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'calendar',
		data() {
			return {
				today: new Date()
			}
		},
		computed: {

		},
		created() {

		}
	}
</script>