import xlrd
import interact
from string import Template


class batch():
	sheet = None
	curr = -1
	end = -1
	key = []

	template_sel = Template("select * from $table")

	template_ins = {
					"airport" : Template("insert $table values(\"$id\", \"$name\", \"$city\");"),
					"flight" : Template("insert $table values(\"$flight_No\", \"$model\", \"$airline\", $seat1_total, $seat2_total, \"$departure_airport\", $transfer_airport1, $transfer_airport2, \"$arrival_airport\");"),
					"inventory" : Template("insert $table values(\"$fNo\", \"$departure_time\", \"$departure_airport\", $seat1_surplus, $seat2_surplus, $seat1_price, $seat2_price, \"$arrival_time\");"),
					}

	def __init__(self):
		pass

	@staticmethod
	def insert():
		if batch.curr == batch.end:
			return "quit;"

		data = batch.sheet.row_values(batch.curr)
		row_dict = {"table" : batch.sheet.name}
		batch.curr -= 1

		for i, value in enumerate(data):
			row_dict[batch.key[i]] = value

		return batch.template_ins[batch.sheet.name].substitute(row_dict)

	@staticmethod
	def clear_post():
		if batch.curr == batch.end:
			return "quit;"

		batch.curr -= 1

		return "delete from post where id = %d"%batch.curr