<template>
	<div style="position: relative;" v-if="image">
		<img :src="image" class="img-fluid">
		<a href="#" class="btn btn-danger" style="position: absolute; right: 0; top: 0;" @click="$emit('close')">
			&times;
		</a>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: {
			preview: {
				type: [String, File],
				default: null
			},
			folder: {
				type: String,
				required:false,
				default: ''
			}
		},
		data() {
			return {
				image: null
			}
		},
		created() {
			this.setPreview()
		},
		watch: {
			'preview': 'setPreview'
		},
		methods: {
			setPreview() {
				if(this.preview instanceof File) {

					const fileReader = new FileReader()
					fileReader.onload = (event) => {
						this.image = event.target.result
					}
					fileReader.readAsDataURL(this.preview)

				} else if(typeof this.preview === 'string') {
					this.image = `${this.folder + this.preview}`
				} else {
					this.image = null
				}
			}
		}
	}
</script>