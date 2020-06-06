import xlrd
import interact
from string import Template
from batch import batch

file_path = "E:/MEGA/数据库/pj/db.xlsx"
sheet_name = "inventory"

if __name__ == '__main__':
	file = xlrd.open_workbook(file_path)

	batch.sheet = file.sheet_by_name(sheet_name)
	batch.row = batch.sheet.nrows - 1
	batch.key = batch.sheet.row_values(0)

	interact.Interact(in_handler = batch.insert)

	'''
	while batch.row != 0:
		print(batch.insert())
	'''
