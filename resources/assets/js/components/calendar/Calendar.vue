<template>
	<div>
		<table class="table">
			<thead>
				<tr>
					<td style="cursor: pointer;" @click="prevMonth">
						<p style="font-size: 10pt">Mes prev.</p>
						<i class="fa fa-arrow-left fa-3x"></i>
					</td>
					<td style="cursor: pointer;" @click="prevYear">
						<p style="font-size: 10pt">Año prev.</p>
						<i class="fa fa-arrow-circle-left fa-3x"></i>
					</td>
					<td colspan="3" @click="logDays">
						<strong>{{ date.month }}/{{ date.year }}</strong>
					</td>
					<td  style="cursor: pointer;" @click="nextYear">
						<p style="font-size: 10pt">Año sig.</p>
						<i class="fa fa-arrow-circle-right fa-3x"></i>
					</td>
					<td style="cursor: pointer;" @click="nextMonth">
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
						<td v-for="day in month" :style="`background-color: ${day.bg ? day.bg : 'white'}`">{{ day.day }}</td>
					</tr>
				</template>
			</tbody>
		</table>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'calendar',
		data() {
			return {
				date: {
					day: 0,
					month: 0,
					year: 0,
				},
				loading: false,
			}
		},
		methods: {
			prevMonth() {
				this.date.month--
				if(this.date.month <= 0) {
					this.date.month = 12
					this.date.year--
					if(this.date.year<=0) {
						this.date.year = 1
					}
				}
			},
			nextMonth() {
				this.date.month++
				if(this.date.month > 12) {
					this.date.month = 1
					this.date.year++
				}
			},
			prevYear() {
				this.date.year--
				if(this.date.year <= 0) {
					this.date.year = 1
				}
			},
			nextYear() {
				this.date.year++
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
			}
		},
		computed: {
			months() {
				let prevMonth = null
				let actualMonth = null
				let nextMonth = null

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
						return this.splitarray(actualMonth.concat(appendDays),7)
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

						return this.splitarray(prependDays.concat(actualMonth.concat(appendDays)),7)
					} else {
						return this.splitarray(prependDays.concat(actualMonth),7)
					}
				}
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
</style>