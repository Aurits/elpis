"use client"

import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from "recharts"

const data = [
  { month: "Jul", amount: 4500000 },
  { month: "Aug", amount: 5200000 },
  { month: "Sep", amount: 4800000 },
  { month: "Oct", amount: 6100000 },
  { month: "Nov", amount: 5900000 },
  { month: "Dec", amount: 7200000 },
]

export function DonationsChart() {
  return (
    <Card className="glass-card">
      <CardHeader>
        <CardTitle>Donations Over Time</CardTitle>
      </CardHeader>
      <CardContent>
        <ResponsiveContainer width="100%" height={300}>
          <LineChart data={data}>
            <CartesianGrid strokeDasharray="3 3" stroke="#2a2a2a" />
            <XAxis dataKey="month" stroke="#a0a0a0" />
            <YAxis stroke="#a0a0a0" tickFormatter={(value) => `${(value / 1000000).toFixed(1)}M`} />
            <Tooltip
              contentStyle={{
                backgroundColor: "#1a1a1a",
                border: "1px solid #2a2a2a",
                borderRadius: "8px",
                color: "#ffffff",
              }}
              formatter={(value: number) => [`UGX ${value.toLocaleString()}`, "Amount"]}
            />
            <Line type="monotone" dataKey="amount" stroke="#ec008c" strokeWidth={2} dot={{ fill: "#ec008c" }} />
          </LineChart>
        </ResponsiveContainer>
      </CardContent>
    </Card>
  )
}
