import pymysql

def Echo(echo):
	print("# echo #")
	for line in echo:
		print("# %s"%str(line))
	print("# end echo #\n")


def main():
	flag = True
	
	while flag:		
		db = pymysql.connect(host = "47.101.211.158", port = 3306, user="mxy", passwd = "123456", db = "ticket_system", charset = "utf8")
		cursor = db.cursor()

		while True:
			cmd = input("# please input cmd #\n>> ")

			while ';' not in cmd:
				cmd += " " + input(">> ")

			if cmd == "quit;":
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
				Echo(echo)

		cursor.close()
		db.close()
	
	
if __name__ == '__main__':
	main()
