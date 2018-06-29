<div id="guest">
	<section class="hero is-light is-bold" style="margin: 52px 0 10px 0">
		<div class="hero-body">
			<div class="container">
				<h1 class="title">
					Guest Book
					<i class="fas fa-book"></i>
				</h1>
				<p class="subtitle">Find recommend place from Guest</p>
			</div>
		</div>
	</section>

	<section class="section">
		<div class="columns" v-if="!loading">
			<div class="column is-8 is-offset-2">
				<p class="title">{{ count }} Recommendations</p>
				<div class="table-responsive">
					<table class="table is-fullwidth is-striped is-bordered">
						<thead>
							<tr>
								<th width="25%">
									<i class="fas fa-user"></i>
									Guest Name
								</th>
								<th width="35%">
									<i class="fas fa-map-marker-alt"></i>
									Place Name
								</th>
								<th width="20%">
									<i class="fas fa-clock"></i>
									Date Created
								</th>
								<th width="20%">
									<i class="fas fa-certificate"></i>
									Action
								</th>
							</tr>
						</thead>
						<tbody v-for="(guest, index) in guests">
							<tr>
								<td>{{ guest.name }}</td>
								<td>{{ guest.place }}</td>
								<td>{{ guest.date | moment }}</td>
								<td>
									<a
										class="button is-danger"
										:href="'<?= base_url() ?>' + 'site/map?id=' + guest.id"
									>
										<span class="icon">
											<i class="fas fa-map-marker-alt"></i>
										</span>
										<span>Show</span>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<div class="has-text-centered" v-if="loading">
		<p class="title">
			<i class="fas fa-spinner fa-spin"></i>
		</p>
		<p class="subtitle">
			Load Data..
		</p>
	</div>
</div>

<script>
const guest = new Vue({
	el: '#guest',
	data: () => ({
		guests: {},
		count: '',
		loading: false
	}),

	mounted() {
		this.fetchData()
	},

	methods: {
		fetchData () {
			this.loading = true

			axios.get('<?= base_url() ?>' + 'guest/place')
				.then(res => {
					this.guests = res.data.data
					this.count = res.data.data.length
					this.loading = false
				})
				.catch(err => {
					console.log(err)
				})
		}
	},

	filters: {
		moment: (date) => moment(date).fromNow()
	}
})
</script>