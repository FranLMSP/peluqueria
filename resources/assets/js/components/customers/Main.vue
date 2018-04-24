<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12">
				<div class="card card-default">
					<p class="card-header">Clientes</p>
					<div class="card-body">
						<router-view></router-view>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'customers-main'
	}
</script>