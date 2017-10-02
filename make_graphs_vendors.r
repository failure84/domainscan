library(Rcpp)
library(anytime)
library(ggplot2)
csvData <- read.csv("r.data")
data <- as.data.frame(csvData)
#print(data)
names(data)[1]="vendor"
names(data)[2]="time"
names(data)[3]="total"
data$time <- anytime::anydate(data$time)
vendoirIDS = unique(data$vendor)
for(i in vendoirIDS){
	singleData <- subset(data, vendor == i)
	ggplot(data=singleData, aes(time, total)) +
		#scale_x_date(date_labels="%Y-%m-%d",date_breaks="1 day") +
		theme(
			axis.text.x = element_text(angle=65, vjust=0.6),
			legend.title=element_text(size=6)
		) +
		#scale_y_continuous(limits = c(0, 12000000)) +
		geom_line() +
		geom_point(colour="#134a72",aes(y= total), size=2, shape=21, fill="#2576b0") +
		geom_text(
		aes(y = total, label = paste(round(total,digits=2),"")),
			position = position_dodge(width = 1),
			size = 2.5,
			vjust = -1.8,
			hjust = 0.3,
			colour = "#268bd2"
		) +
		labs(
			title="DomainScan",
			subtitle=paste(c("vendor id: "), i),
			caption="",
			y="domains",
			x='Dates'
	    )
	ggsave(
		filename = paste(c("/home/patbat/domainscan/websrc/domainscan/webroot/img/domain_",i ,".png" ), collapse = ""),
		width = 20,
		height = 14,
		units = "cm"
	)
}
