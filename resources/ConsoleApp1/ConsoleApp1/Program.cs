using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.Text;
using static System.Console;
using System.Threading;
using System.IO.Ports;

namespace ConsoleApp1
{
    class Program
    {
        static void Main(string[] args)
        {
            DBConnect db = new DBConnect();
            Console.WriteLine("COM PORT Number:");
            int COM_NUMBER = Convert.ToInt32(Console.ReadLine());

            try
            {
                SerialPort sp = new SerialPort();
                sp.PortName = "COM" + COM_NUMBER;
                sp.BaudRate = 9600;
                sp.DataBits = 8;
                sp.StopBits = StopBits.One;
                sp.Open();

                string t = "";
                string h = "";
                string br = "";


                if (db.OpenConnection())
                {
                    //db.deleteOld();
                    while (true)
                    {
                        string s = "";
                        s = sp.ReadLine();

                        if (s.Length > 0)
                        {
                            String[] data = s.Split(',');
                            int i = 0;
                            for (i = 0; i < data.Length; i++)
                            {
                                if (data.Length == 3)
                                {
                                    h = data[0];
                                    t = data[1];
                                    br = data[2];
                                }
                            }


                            Random rand = new Random();
                            var time = DateTime.Now;
                            string date = time.ToString("yyyy-MM-dd");
                            string ttime = time.ToString("hh:mm:ss");
                            string temp = rand.Next(100).ToString();
                            string brea = rand.Next(100).ToString();
                            string hum = rand.Next(100).ToString();

                            Console.WriteLine("Temperature: " + temp);
                            Console.WriteLine("Humidity: " + hum);
                            Console.WriteLine("Breathing Rate: " + brea);

                            db.Insert(4, temp, brea, hum, date, ttime);
                            //db.Insert(4, t, br, h, date, ttime);

                            //Thread.Sleep(1000);

                            //float humidity = 0;// float.Parse(hum);
                            //float temperature = 0;// float.Parse(temp);
                            //float breathing_rate = 0;
                            //try
                            //{
                            //    humidity = float.Parse(hum);
                            //    temperature = float.Parse(temp);
                            //    breathing_rate = float.Parse(br);

                            //}
                            //catch (Exception ex)
                            //{
                            //    Console.WriteLine("Parsing Error: .........................\n" + ex.ToString());
                            //}
                        }
                    }
                    db.CloseConnection();

                }

            }
            catch (Exception ex)
            {
                Console.WriteLine("COM PORT ERROR! \n\n........................................................................\n\n" + ex.ToString());
                Console.ReadLine();
            }


            //while (true)
            //{

            //    //string formattedTime = time.ToString("yyyy, MM, dd, hh, mm, ss");
            //    //WriteLine(date);
            //    //WriteLine(ttime);
            //    Thread.Sleep(1000);
            //}

        }

    }

    class DBConnect
    {
        private MySqlConnection connection;
        private string server;
        private string database;
        private string uid;
        private string password;


        public DBConnect()
        {
            Initialize();
        }

        #region DB basic methods
        private void Initialize()
        {
            server = "localhost";
            database = "infantincubator";
            uid = "root";
            password = "";
            string connectionString;
            connectionString = "SERVER=" + server + ";" + "DATABASE=" +
            database + ";" + "UID=" + uid + ";" + "PASSWORD=" + password + ";" + "PORT=3306;";
            connection = new MySqlConnection(connectionString);
        }

        public bool OpenConnection()
        {
            try
            {
                connection.Open();
                WriteLine("Connected");
                ReadLine();
                return true;
            }
            catch (MySqlException ex)
            {
                switch (ex.Number)
                {
                    case 0:
                        WriteLine("Cannot connect to server.  Contact administrator");
                        ReadLine();
                        break;

                    case 1045:
                        WriteLine("Invalid username/password, please try again");
                        ReadLine();
                        break;
                    default:
                        WriteLine("Failed to connect!");
                        ReadLine();
                        break;
                }
                return false;
            }
        }

        public bool CloseConnection()
        {
            try
            {
                connection.Close();
                return true;
            }
            catch (MySqlException ex)
            {
                WriteLine(ex.Message);
                return false;
            }
        }
        #endregion

        public void Insert(int id, string temp, string brea, string hum, string date, string time)
        {
            string query = $"INSERT INTO `sensors_data` (`infant` ,`data_temperature`,`data_breathing`, `data_humidity`, `date_data`, `time_data`) VALUES ('{id}', '{temp}', '{brea}', '{hum}', '{date}', '{time}');";
            //open connection
            //if (this.OpenConnection() == true)
            //{
            //create command and assign the query and connection from the constructor
            MySqlCommand cmd = new MySqlCommand(query, connection);

            //Execute command
            cmd.ExecuteNonQuery();
            WriteLine("Inserted");

            //close connection
            //this.CloseConnection();
            //}
        }

        public void deleteOld()
        {
            string query = "DELETE FROM sensors_data";
            MySqlCommand cmd = new MySqlCommand(query, connection);
            cmd.ExecuteNonQuery();
            WriteLine("Deleted");
        }
    }
}
