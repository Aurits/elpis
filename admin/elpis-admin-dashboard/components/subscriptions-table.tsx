"use client"

import { useState } from "react"
import { subscriptions, type Subscription } from "@/lib/sample-data"
import { Badge } from "@/components/ui/badge"
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table"
import { Card, CardContent } from "@/components/ui/card"
import { Checkbox } from "@/components/ui/checkbox"
import { Search, Download, Mail, History } from "lucide-react"
import { Switch } from "@/components/ui/switch"
import { useToast } from "@/hooks/use-toast"

export function SubscriptionsTable() {
  const { toast } = useToast()
  const [searchQuery, setSearchQuery] = useState("")
  const [statusFilter, setStatusFilter] = useState("all")
  const [regionFilter, setRegionFilter] = useState("all")
  const [currentPage, setCurrentPage] = useState(1)
  const [selectedIds, setSelectedIds] = useState<Set<string>>(new Set())

  const itemsPerPage = 10

  // Filter subscriptions
  const filteredSubscriptions = subscriptions.filter((sub) => {
    const matchesSearch =
      sub.subscriberName.toLowerCase().includes(searchQuery.toLowerCase()) ||
      sub.email.toLowerCase().includes(searchQuery.toLowerCase()) ||
      sub.phone.includes(searchQuery)
    const matchesStatus = statusFilter === "all" || sub.status === statusFilter
    const matchesRegion = regionFilter === "all" || sub.region === regionFilter

    return matchesSearch && matchesStatus && matchesRegion
  })

  // Pagination
  const totalPages = Math.ceil(filteredSubscriptions.length / itemsPerPage)
  const startIndex = (currentPage - 1) * itemsPerPage
  const paginatedSubscriptions = filteredSubscriptions.slice(startIndex, startIndex + itemsPerPage)

  // Get unique regions
  const regions = Array.from(new Set(subscriptions.map((sub) => sub.region)))

  const toggleSelection = (id: string) => {
    const newSelected = new Set(selectedIds)
    if (newSelected.has(id)) {
      newSelected.delete(id)
    } else {
      newSelected.add(id)
    }
    setSelectedIds(newSelected)
  }

  const toggleSelectAll = () => {
    if (selectedIds.size === paginatedSubscriptions.length) {
      setSelectedIds(new Set())
    } else {
      setSelectedIds(new Set(paginatedSubscriptions.map((sub) => sub.id)))
    }
  }

  const sendNewsletter = (toSelected = false) => {
    const count = toSelected ? selectedIds.size : filteredSubscriptions.length
    toast({
      title: "Newsletter Sent",
      description: `Newsletter has been sent to ${count} subscriber${count !== 1 ? "s" : ""}.`,
    })
    if (toSelected) setSelectedIds(new Set())
  }

  const exportSelected = () => {
    toast({
      title: "Export Started",
      description: `Exporting ${selectedIds.size} selected subscribers.`,
    })
  }

  const toggleStatus = (subscription: Subscription) => {
    toast({
      title: "Status Updated",
      description: `${subscription.subscriberName} is now ${subscription.status === "Active" ? "Inactive" : "Active"}.`,
    })
  }

  const getStatusBadge = (status: Subscription["status"]) => {
    const variants = {
      Active: "bg-success/20 text-success border-success/50",
      Inactive: "bg-muted text-muted-foreground border-border",
    }
    return (
      <Badge variant="outline" className={variants[status]}>
        {status}
      </Badge>
    )
  }

  return (
    <div className="space-y-4">
      {/* Filters */}
      <Card className="glass-card">
        <CardContent className="p-4">
          <div className="grid gap-4 md:grid-cols-4">
            <div className="relative md:col-span-2">
              <Search className="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
              <Input
                placeholder="Search by name, email, or phone..."
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
                className="pl-9"
              />
            </div>
            <Select value={statusFilter} onValueChange={setStatusFilter}>
              <SelectTrigger>
                <SelectValue placeholder="Status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Status</SelectItem>
                <SelectItem value="Active">Active</SelectItem>
                <SelectItem value="Inactive">Inactive</SelectItem>
              </SelectContent>
            </Select>
            <Select value={regionFilter} onValueChange={setRegionFilter}>
              <SelectTrigger>
                <SelectValue placeholder="Region" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Regions</SelectItem>
                {regions.map((region) => (
                  <SelectItem key={region} value={region}>
                    {region}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
          </div>
          <div className="mt-4 flex items-center justify-between">
            <p className="text-sm text-muted-foreground">
              Showing {startIndex + 1}-{Math.min(startIndex + itemsPerPage, filteredSubscriptions.length)} of{" "}
              {filteredSubscriptions.length} subscriptions
              {selectedIds.size > 0 && ` (${selectedIds.size} selected)`}
            </p>
            <div className="flex gap-2">
              {selectedIds.size > 0 && (
                <>
                  <Button variant="outline" size="sm" onClick={() => sendNewsletter(true)}>
                    <Mail className="mr-2 h-4 w-4" />
                    Send to Selected
                  </Button>
                  <Button variant="outline" size="sm" onClick={exportSelected}>
                    <Download className="mr-2 h-4 w-4" />
                    Export Selected
                  </Button>
                </>
              )}
            </div>
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
                  <TableHead className="w-12">
                    <Checkbox
                      checked={selectedIds.size === paginatedSubscriptions.length && paginatedSubscriptions.length > 0}
                      onCheckedChange={toggleSelectAll}
                    />
                  </TableHead>
                  <TableHead>Subscriber Name</TableHead>
                  <TableHead>Email</TableHead>
                  <TableHead>Phone</TableHead>
                  <TableHead>Region</TableHead>
                  <TableHead>Subscription Date</TableHead>
                  <TableHead>Status</TableHead>
                  <TableHead>Last Email Sent</TableHead>
                  <TableHead className="text-right">Actions</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {paginatedSubscriptions.map((sub) => (
                  <TableRow key={sub.id} className="hover:bg-muted/50">
                    <TableCell>
                      <Checkbox checked={selectedIds.has(sub.id)} onCheckedChange={() => toggleSelection(sub.id)} />
                    </TableCell>
                    <TableCell className="font-medium">{sub.subscriberName}</TableCell>
                    <TableCell className="text-muted-foreground">{sub.email}</TableCell>
                    <TableCell className="font-mono text-sm">{sub.phone}</TableCell>
                    <TableCell>{sub.region}</TableCell>
                    <TableCell>{sub.subscriptionDate.toLocaleDateString()}</TableCell>
                    <TableCell>
                      <div className="flex items-center gap-2">
                        {getStatusBadge(sub.status)}
                        <Switch checked={sub.status === "Active"} onCheckedChange={() => toggleStatus(sub)} />
                      </div>
                    </TableCell>
                    <TableCell>{sub.lastEmailSent.toLocaleDateString()}</TableCell>
                    <TableCell className="text-right">
                      <div className="flex justify-end gap-2">
                        <Button variant="ghost" size="sm">
                          <History className="h-4 w-4" />
                        </Button>
                        <Button variant="ghost" size="sm" onClick={() => sendNewsletter(false)}>
                          <Mail className="h-4 w-4" />
                        </Button>
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
