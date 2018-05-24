<template>
	<div>
		<div class="row">
			<div class="col-sm-12">
				<table class="table">
					<thead>
						<tr>
							<td @click="prevMonth">
								<p style="font-size: 10pt">Mes prev.</p>
								<i class="fa fa-arrow-left fa-3x"></i>
							</td>
							<td @click="prevYear">
								<p style="font-size: 10pt">Año prev.</p>
								<i class="fa fa-arrow-circle-left fa-3x"></i>
							</td>
							<td colspan="3" @click="logDays">
								<strong>{{ date.month }}/{{ date.year }}</strong>
							</td>
							<td  @click="nextYear">
								<p style="font-size: 10pt">Año sig.</p>
								<i class="fa fa-arrow-circle-right fa-3x"></i>
							</td>
							<td @click="nextMonth">
								<p style="font-size: 10pt">Mes sig.</p>
								<i class="fa fa-arrow-right fa-3x"></i>
							</td>
						</tr>
						<tr>
							<th>L</th>
							<th>M</th>
							<th>M</th>
							<th>J</th>
							<th>V</th>
							<th><span style="color: red;">S</span></th>
							<th><span style="color: red;">D</span></th>
						</tr>
					</thead>
					<tbody>
						<template v-if="loading">
							<tr>
								<td colspan="7">Cargando...</td>
							</tr>
						</template>
						<template v-else>
							<tr v-for="month in months">
								<td @click="showDayData(day)" v-for="day in month" :style="`background-color: ${day.bg ? day.bg : 'white'}`" class="text-center">
									<span :class="`${day.data ? 'cell-data' : 'cell'} ${day.date == selected.date ? 'selected' : ''}`">{{ day.day }}</span>
								</td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				
				<List></List>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
			</div>
		</div>

	</div>
</template>

<script type="text/javascript">

	import List from './List.vue'

	export default {
		name: 'calendar',
		components: {
			List
		},
		data() {
			return {
				date: {
					day: 0,
					month: 0,
					year: 0,
				},
				loadedDates: [],
				selected: {
					date: new Date()
				},
				loading: false,
			}
		},
		methods: {
			get(){
				this.loadedDates = []
				this.loading = true

				axios.get('/api/calendar/month/' + this.date.year + '-' + this.date.month)
				.then( response => {
					console.log(response.data)
					this.loadedDates = response.data.calendar
				}).catch( error => {
					alert('Ocurrió un error al obtener el calendario')
				})
				.then( () => {
					this.loading = false
				})
			},
			findDay(months, date) {
				
				const date2 = new Date(date)
				for(let i = 0; i<months.length; i++) {
					for(let j = 0; j<months[i].length; j++) {
						let date1 = new Date(months[i][j].date)
						if(date1.getMonth() == date2.getMonth() && date1.getDate() == date2.getDate())
							return [i, j]
					}
				}
				return false
			},
			prevMonth() {
				this.date.month--
				if(this.date.month <= 0) {
					this.date.month = 12
					this.date.year--
					if(this.date.year<=0) {
						this.date.year = 1
					}
				}

				this.get()
			},
			nextMonth() {
				this.date.month++
				if(this.date.month > 12) {
					this.date.month = 1
					this.date.year++
				}
				this.get()
			},
			prevYear() {
				this.date.year--
				if(this.date.year <= 0) {
					this.date.year = 1
				}
				this.get()
			},
			nextYear() {
				this.date.year++
				this.get()
			},
			getDaysInMonth(month, year) {
				month--
			    const date = new Date(year, month, 1)
			    let days = []
			    while (date.getMonth() === month) {
				    days.push({
		        		weekDay: date.getDay() ? date.getDay() : 7,
			        	day: date.getDate(),
			        	month: date.getMonth() +1,
			        	year: date.getFullYear(),
			        	date: new Date(date)
			        });
			        date.setDate(date.getDate() + 1)
			    }
			    return days
			},
			logDays() {
				console.log(this.months)
			},
			splitarray(input, spacing) {
			    let output = [];

			    for (let i = 0; i < input.length; i += spacing)
			    {
			        output[output.length] = input.slice(i, i + spacing);
			    }

			    return output;
			},
			showDayData(day) {
				if(day.data) {
					this.selected = day
					console.log(day)
				}
			},
		},
		computed: {
			months() {
				let prevMonth = null
				let actualMonth = null
				let nextMonth = null

				let months = []

				if(this.date.month == 1) {
					prevMonth = this.getDaysInMonth(12, this.date.year - 1)
					actualMonth = this.getDaysInMonth(this.date.month, this.date.year)
					nextMonth = this.getDaysInMonth(this.date.month+1, this.date.year)
				} else if (this.date.month == 12) {
					prevMonth = this.getDaysInMonth(11, this.date.year)
					actualMonth = this.getDaysInMonth(this.date.month, this.date.year)
					nextMonth = this.getDaysInMonth(1, this.date.year+1)
				} else {				
					prevMonth = this.getDaysInMonth(this.date.month-1, this.date.year)
					actualMonth = this.getDaysInMonth(this.date.month, this.date.year)
					nextMonth = this.getDaysInMonth(this.date.month+1, this.date.year)
				}

				if(actualMonth[0].weekDay == 1) {
					if(actualMonth[actualMonth.length-1].weekDay != 7) {

						let appendDays = []
						for (let i = 0; i<nextMonth.length; i++) {
							if(nextMonth[i].weekDay != 1) {
								nextMonth[i].bg = 'grey'
								appendDays.push(nextMonth[i])
							} else {
								break
							}
						}
						months = this.splitarray(actualMonth.concat(appendDays),7)
					}
				} else {
					let prependDays = []
					for(let i = prevMonth.length-1; i>=0; i--) {
						if(prevMonth[i].weekDay != 7) {
							prevMonth[i].bg = 'grey'
							prependDays.unshift(prevMonth[i])
						} else {
							break
						}
					}

					if(actualMonth[actualMonth.length-1].weekDay < 7) {

						let appendDays = []
						for (let i = 0; i<nextMonth.length; i++) {
							if(nextMonth[i].weekDay != 1) {
								nextMonth[i].bg = 'grey'
								appendDays.push(nextMonth[i])
							} else {
								break
							}
						}

						months = this.splitarray(prependDays.concat(actualMonth.concat(appendDays)),7)
					} else {
						months = this.splitarray(prependDays.concat(actualMonth),7)
					}


				}
				for (let i = 0; i<this.loadedDates.length; i++) {
					let finded = this.findDay(months, new Date(this.loadedDates[i].date))

					if(finded!==false) {
						if (!months[finded[0]][finded[1]].data) {

							months[finded[0]][finded[1]].data = [this.loadedDates[i]]
						} else {
							months[finded[0]][finded[1]].data.push(this.loadedDates[i])
						}
					}

				}
				
				return months
			},
			selectedDate() {
				return  new Date(this.date.year + '-' + this.date.month + '-' + this.date.day)
			}
		},
		created() {
			const date = new Date()
			this.date = {
				day: date.getDate(),
				month: date.getMonth() + 1,
				year: date.getFullYear()
			}

			this.get()
		}
	}
</script>

<style>
	table th {
		text-align: center;
	}

	table td {
		text-align: center;
		font-size: large;
	}

	td > span {
		display:block;
		text-align: center;
		margin:0 auto;
		padding: 5px;
		width: 50px;
		border-radius: 10px;
	}

	td:hover {
		cursor: pointer;
	}

	td > span.cell, td > span.cell-data {
		background-color: white;
	}

	td:hover > span.cell, td:hover > span.cell-data  {
		background-color: lightgray;
	}

	.cell {
		color: black;
	}

	.cell-data {
		color: red;
		font-weight: bold;
	}

	.selected {
		border-color: black;
		border-style: dashed;
		border-width: 5px;
	}
</style>