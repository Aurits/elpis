"use client"

import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from "recharts"

const data = [
  { department: "Education", count: 12 },
  { department: "Healthcare", count: 8 },
  { department: "Community Dev", count: 10 },
  { department: "Finance", count: 6 },
  { department: "Operations", count: 7 },
  { department: "Marketing", count: 7 },
]

export function ApplicationsChart() {
  return (
    <Card className="glass-card">
      <CardHeader>
        <CardTitle>Applications by Department</CardTitle>
      </CardHeader>
      <CardContent>
        <ResponsiveContainer width="100%" height={300}>
          <BarChart data={data}>
            <CartesianGrid strokeDasharray="3 3" stroke="#2a2a2a" />
            <XAxis dataKey="department" stroke="#a0a0a0" angle={-45} textAnchor="end" height={80} />
            <YAxis stroke="#a0a0a0" />
            <Tooltip
              contentStyle={{
                backgroundColor: "#1a1a1a",
                border: "1px solid #2a2a2a",
                borderRadius: "8px",
                color: "#ffffff",
              }}
            />
            <Bar dataKey="count" fill="#00aeef" radius={[8, 8, 0, 0]} />
          </BarChart>
        </ResponsiveContainer>
      </CardContent>
    </Card>
  )
}
