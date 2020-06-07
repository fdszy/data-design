import pymysql

def Input() -> str:
	print("# please input cmd #")

	cmd = ""
	while True:
		cmd += " " + input(">> ")

		if ';' in cmd:
			break

	return cmd


def Output(echo):
	print("# echo #")

	for line in echo:
		print("# %s"%str(line))

	print("# end echo #\n")


def Interact(in_handler = Input, out_handler = Output):
	flag = True
	
	while flag:		
		db = pymysql.connect(host = "47.101.211.158", port = 3306, user = "mxy", passwd = "123456", db = "ticket_system", charset = "utf8")
		cursor = db.cursor()

		while True:
			cmd = in_handler()
			
			if "quit;" in cmd:
				flag = False
				break

			try:
				cursor.execute(cmd)
				db.commit()
			except:
				print("# exception #")
				break
			else:
				echo = cursor.fetchall()
				out_handler(echo)

		cursor.close()
		db.close()
	
	print("# Bye~ #")
	
if __name__ == '__main__':
	Interact()
