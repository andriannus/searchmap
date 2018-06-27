<div id="app">
	<nav class="navbar is-fixed-top is-light" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<a class="navbar-item" href="https://bulma.io">
				SEARCH MAP
			</a>

			<a role="button" class="navbar-burger" :class="{ 'is-active': isActive }" aria-label="menu" aria-expanded="false" @click="switchMenu">
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
				<span aria-hidden="true"></span>
			</a>
		</div>

		<div class="navbar-menu" :class="{ 'is-active': isActive }">
			<div class="navbar-start">
				<a class="navbar-item is-active">
					Home
				</a>
				<a class="navbar-item" href="<?= base_url('site/map') ?>">
					Map
				</a>
			</div>

			<div class="navbar-end">
				<div class="navbar-item">
					<div class="field is-grouped">
						<p class="control">
							<a class="button is-dark" href="https://github.com/andriannus/searchmap">
								<span class="icon">
									<i class="fab fa-github"></i>
								</span>
								<span>Github</span>
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</nav>
</div>

<script>
const app = new Vue({
	el: '#app',
	data: () => ({
		isActive: false
	}),

	methods: {
		switchMenu () {
			this.isActive = !this.isActive
		}
	}
})
</script>