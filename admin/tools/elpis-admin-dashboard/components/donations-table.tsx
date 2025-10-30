"use client"

import { useState } from "react"
import { donations, type Donation } from "@/lib/sample-data"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import { Card, CardContent } from "@/components/ui/card"
import { Search, Download, Receipt, Mail } from "lucide-react"
import { useToast } from "@/hooks/use-toast"

export function DonationsTable() {
  const { toast } = useToast()
  const [searchQuery, setSearchQuery] = useState("")
  const [paymentMethodFilter, setPaymentMethodFilter] = useState("all")
  const [statusFilter, setStatusFilter] = useState("all")
  const [currentPage, setCurrentPage] = useState(1)

  const itemsPerPage = 10

  // Filter donations
  const filteredDonations = donations.filter((donation) => {
    const matchesSearch =
      donation.donorName.toLowerCase().includes(searchQuery.toLowerCase()) ||
      donation.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
      donation.transactionId.toLowerCase().includes(searchQuery.toLowerCase())
    const matchesPaymentMethod = paymentMethodFilter === "all" || donation.paymentMethod === paymentMethodFilter
    const matchesStatus = statusFilter === "all" || donation.status === statusFilter

    return matchesSearch && matchesPaymentMethod && matchesStatus
  })

  // Calculate summary metrics
  const thisMonthDonations = donations.filter((d) => {
    const now = new Date()
    return d.date.getMonth() === now.getMonth() && d.date.getFullYear() === now.getFullYear()
  })
  const totalThisMonth = thisMonthDonations.reduce((sum, d) => sum + d.amount, 0)
  const averageDonation = donations.reduce((sum, d) => sum + d.amount, 0) / donations.length
  const paymentMethodCounts = donations.reduce(
    (acc, d) => {
      acc[d.paymentMethod] = (acc[d.paymentMethod] || 0) + 1
      return acc
    },
    {} as Record<string, number>,
  )
  const mostPopularMethod = Object.entries(paymentMethodCounts).sort((a, b) => b[1] - a[1])[0]?.[0] || "N/A"

  // Pagination
  const totalPages = Math.ceil(filteredDonations.length / itemsPerPage)
  const startIndex = (currentPage - 1) * itemsPerPage
  const paginatedDonations = filteredDonations.slice(startIndex, startIndex + itemsPerPage)

  const exportToExcel = () => {
    toast({
      title: "Export Started",
      description: "Your Excel file is being prepared for download.",
    })
  }

  const sendThankYou = (donation: Donation) => {
    toast({
      title: "Thank You Email Sent",
      description: `A thank you email has been sent to ${donation.donorName}.`,
    })
  }

  const getStatusBadge = (status: Donation["status"]) => {
    const variants = {
      Success: "bg-success/20 text-success border-success/50",
      Pending: "bg-warning/20 text-warning border-warning/50",
      Failed: "bg-error/20 text-error border-error/50",
    }
    return (
      <Badge variant="outline" className={variants[status]}>
        {status}
      </Badge>
    )
  }

  return (
    <div className="space-y-4">
      {/* Summary Cards */}
      <div className="grid gap-4 md:grid-cols-3">
        <Card className="glass-card">
          <CardContent className="p-4">
            <p className="text-sm font-medium text-muted-foreground">Total Donations (This Month)</p>
            <p className="mt-2 text-2xl font-bold">UGX {totalThisMonth.toLocaleString()}</p>
          </CardContent>
        </Card>
        <Card className="glass-card">
          <CardContent className="p-4">
            <p className="text-sm font-medium text-muted-foreground">Average Donation Amount</p>
            <p className="mt-2 text-2xl font-bold">UGX {Math.round(averageDonation).toLocaleString()}</p>
          </CardContent>
        </Card>
        <Card className="glass-card">
          <CardContent className="p-4">
            <p className="text-sm font-medium text-muted-foreground">Most Popular Payment Method</p>
            <p className="mt-2 text-2xl font-bold">{mostPopularMethod}</p>
          </CardContent>
        </Card>
      </div>

      {/* Filters */}
      <Card className="glass-card">
        <CardContent className="p-4">
          <div className="grid gap-4 md:grid-cols-4">
            <div className="relative md:col-span-2">
              <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
              <Input
                placeholder="Search by name, email, or transaction ID..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-9"
              />
            </div>
            <Select value={paymentMethodFilter} onValueChange={setPaymentMethodFilter}>
              <SelectTrigger>
                <SelectValue placeholder="Payment Method" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Methods</SelectItem>
                <SelectItem value="Mobile Money">Mobile Money</SelectItem>
                <SelectItem value="Bank">Bank</SelectItem>
                <SelectItem value="Card">Card</SelectItem>
              </SelectContent>
            </Select>
            <Select value={statusFilter} onValueChange={setStatusFilter}>
              <SelectTrigger>
                <SelectValue placeholder="Status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Status</SelectItem>
                <SelectItem value="Success">Success</SelectItem>
                <SelectItem value="Pending">Pending</SelectItem>
                <SelectItem value="Failed">Failed</SelectItem>
              </SelectContent>
            </Select>
          </div>
          <div className="mt-4 flex items-center justify-between">
            <p className="text-sm text-muted-foreground">
              Showing {startIndex + 1}-{Math.min(startIndex + itemsPerPage, filteredDonations.length)} of{" "}
              {filteredDonations.length} donations
            </p>
            <Button variant="outline" size="sm" onClick={exportToExcel}>
              <Download className="mr-2 h-4 w-4" />
              Export Excel
            </Button>
          </div>
        </CardContent>
      </Card>

      {/* Table */}
      <Card className="glass-card">
        <CardContent className="p-0">
          <div className="overflow-x-auto">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Donor Name</TableHead>
                  <TableHead>Email</TableHead>
                  <TableHead>Amount</TableHead>
                  <TableHead>Payment Method</TableHead>
                  <TableHead>Transaction ID</TableHead>
                  <TableHead>Date</TableHead>
                  <TableHead>Status</TableHead>
                  <TableHead className="text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {paginatedDonations.map((donation) => (
                  <TableRow key={donation.id} className="hover:bg-muted/50">
                    <TableCell className="font-medium">{donation.donorName}</TableCell>
                    <TableCell className="text-muted-foreground">{donation.email}</TableCell>
                    <TableCell className="font-mono">UGX {donation.amount.toLocaleString()}</TableCell>
                    <TableCell>{donation.paymentMethod}</TableCell>
                    <TableCell className="font-mono text-sm">{donation.transactionId}</TableCell>
                    <TableCell>{donation.date.toLocaleDateString()}</TableCell>
                    <TableCell>{getStatusBadge(donation.status)}</TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-2">
                        <Button variant="ghost" size="sm">
                          <Receipt className="h-4 w-4" />
                        </Button>
                        {donation.status === "Success" && (
                          <Button variant="ghost" size="sm" onClick={() => sendThankYou(donation)}>
                            <Mail className="h-4 w-4" />
                          </Button>
                        )}
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>
        </CardContent>
      </Card>

      {/* Pagination */}
      <div className="flex items-center justify-between">
        <Button variant="outline" disabled={currentPage === 1} onClick={() => setCurrentPage(currentPage - 1)}>
          Previous
        </Button>
        <span className="text-sm text-muted-foreground">
          Page {currentPage} of {totalPages}
        </span>
        <Button variant="outline" disabled={currentPage === totalPages} onClick={() => setCurrentPage(currentPage + 1)}>
          Next
        </Button>
      </div>
    </div>
  )
}
