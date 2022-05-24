using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace testHTTPPostJson
{
    class Program
    {
        static void Main(string[] args)
        {
            StreamReader file = new StreamReader("Schedule.json") ;
            string temp = file.ReadToEnd();
            file.Close();
            /* Console.WriteLine(temp);

             JObject jObject = JObject.Parse(temp);

             var tokGroup = jObject.GetValue("FacultyName");

             Console.WriteLine(tokGroup);*/



            string url = @"http://math.nosu.ru/schedule/getAnswer.php"; 


            string postParameters = "name=updateFacultyMain&json=" + temp;
            HttpWebRequest httpWebRequest = (HttpWebRequest)WebRequest.Create(url);
            httpWebRequest.Method = "POST";
            byte[] byteArray = System.Text.Encoding.UTF8.GetBytes(postParameters);
            httpWebRequest.ContentType = "application/x-www-form-urlencoded";
            httpWebRequest.ContentLength = byteArray.Length;
            using (var writer = httpWebRequest.GetRequestStream())
            {
                writer.Write(byteArray, 0, byteArray.Length);
            }

            //HttpWebResponse httpWebResponse = (HttpWebResponse)httpWebRequest.GetResponse();
            Console.WriteLine("!!!!");

        }
    }
}
