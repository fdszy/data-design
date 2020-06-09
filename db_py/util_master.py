from datetime import date, datetime, timedelta
import time
from math import log
from random import randint, choice

def weekday_cycle_m (year, month, day = 1, cycle = 1):
	weekday_cycle = [[] for i in range(7)]
	date_curr = date(year, month, day)
	date_end = date(year + int((month + cycle) / 12), (month + cycle) % 12, day)
	
	while date_curr < date_end:
		weekday = date_curr.weekday()
		weekday_cycle[weekday].append("%d-%d-%d"%(date_curr.year, date_curr.month, date_curr.day))
		date_curr += timedelta(days = 1)
	
	return weekday_cycle

def str_date_inc (str_date, inc = 1) -> str:
	[year, month, day] = [int(i) for i in str_date.split("-")]
	date_curr = date(year, month, day)
	date_curr += timedelta(days = inc)

	return "%d-%d-%d"%(date_curr.year, date_curr.month, date_curr.day)


def minute_delta (t1, t2, cross = True):

	[h1, m1] = [int(i) for i in t1.split(":")]
	[h2, m2] = [int(i) for i in t2.split(":")]

	if cross and h2 < h1:
		return 60 *(24 - h1 + h2) + m2 - m1	
	else:
		return 60 * (h2 - h1) + m2 - m1

def eco_price (time):
	if time < 120:
		distance = time * 15
	else:
		distance = (120 + (time - 120) ** 0.8) * 15

	base = log(150, 0.6 * distance) * distance * 1.1
	base = base // 10 * 10
	bias = choice([0, 0, 0, 0, 10, 10, 10, 20, 20, 50, 80, 120]) * (-1) ** randint(0, 1)

	return base + bias

def first_price (time):
	if time < 150:
		distance = 1800 + 25 * (time ** 0.5)
	else:
		distance = (150 + (time - 150) ** 0.8) * 15

	base = log(360, 0.6 * distance) * distance * 1.9
	base = base // 10 * 10
	bias = choice([0, 0, 0, 0, 50, 50, 80, 80, 80, 150, 120, 120]) * (-1) ** randint(0, 1)

	return base + bias
