<template>
	<div class="image">
		<image-preview :folder="folder" :preview="value" @close="$emit('input', null)" v-if="value"></image-preview>

		<div class="image-upload" v-else>
			<input type="file" accept="images/*" @change="upload">
		</div>
	</div>
</template>


<script type="text/javascript">
	import ImagePreview from './ImagePreview'

	export default {
		components: {
			ImagePreview
		},
		props: {
			value: {
				type: [String, File],
				default: null
			},
			folder: {
				type: String,
				required: true,
				default: ''
			}
		},
		methods: {
			upload(e) {
				const files = e.target.files

				if (files && files.length > 0) {
					this.$emit('input', files[0])
				}
			}
		},
		data() {
			return {

			}
		}
	}
</script>

<style type="text/css">
	.image-upload {
		/*min-height: 257px;*/
		/*width: 100%;*/
		background: #fafafa;
		border: 1px dashed rgba(0, 0, 0, 0.1);
		display: flex;
		justify-content: center;
		align-items: center;
	}
</style>