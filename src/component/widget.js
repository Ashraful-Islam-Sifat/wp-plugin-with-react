import axios from "axios";
import React, { useEffect, useState } from "react";
import { CartesianGrid, Legend, Line, LineChart, Tooltip, XAxis, YAxis } from "recharts";

const Widget = () => {
  
  const [ApiData, setApiData] = useState();
  const url = `${appLocalizer.apiUrl}/wpwr/v2/settings`;

  useEffect(() => {
    axios.get(url).then((res) => {
      setApiData(res.data)
    })
  }, []);

    const data = ApiData;

    const changeFilter = (e) => {
      const filterUrl = `${appLocalizer.apiUrl}/wpwr/v2/last-n-days/${e.target.value}`;
      axios.get(filterUrl).then((res) => {
        setApiData(res.data);
      });
    };

    return (
        <div>
            <h2 style={{display: "inline"}}>Widget</h2>

            <div style={{ float: "right" }}>
              <select title="Select" onChange={changeFilter} defaultValue="">
                <option value="" disabled>Select a Time Range</option>
                <option value="7">Last 7 Days</option>
                <option value="15">Last 15 Days</option>
                <option value="30">Last 30 Days</option>
              </select>
            </div>
                <LineChart 
                    width={400}
                    height={300}
                    data={data}
                    margin={{
                        top: 5,
                        right: 30,
                        left: 20,
                        bottom: 5
                    }}
                >
                    <CartesianGrid strokeDasharray="3 3" />
                    <XAxis dataKey="name" />
                    <YAxis />
                    <Tooltip />
                    <Legend />
                    <Line 
                        type="monotone"
                        dataKey="pv"
                        stroke="#8884d8"
                        activeDot={{r:8}}
                    />
                    <Line 
                        type="monotone"
                        dataKey="uv"
                        stroke="#82ca9d"
                    />
                </LineChart>
        </div>
    )
}

export default Widget;