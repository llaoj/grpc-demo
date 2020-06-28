package app

import (
	"context"
	"io"
	// "fmt"

	"grpc-server/api/protobuf/gen"
	"grpc-server/model"
	"grpc-server/pkg/dic"
)

type Job struct{}

func (j *Job) GetCard(ctx context.Context, in *gen.JobRq) (*gen.JobCardRp, error) {
	rp := loadJobCards(int(in.Id))

	return rp, nil
}

func (j *Job) GetCards(stream gen.JobService_GetCardsServer) error {
	for {
		in, err := stream.Recv()
		if err == io.EOF {
			return nil
		}
		if err != nil {
			return err
		}

		rp := loadJobCards(int(in.Id))
		if err := stream.Send(rp); err != nil {
			return err
		}
	}
}

func loadJobCards(id int) *gen.JobCardRp {

	var job model.Job
	where := map[string]interface{}{"id": id}
	job.Get(where)
	rp := new(gen.JobCardRp)

	rp.Id = int64(job.Id)
	rp.Name = job.Name
	rp.UpdatedAt = job.UpdatedAt.String()

	var company model.Company
	rp.CompanyName = company.GetName(job.CompanyId)

	if v, ok := dic.JobStatus[job.Status]; ok {
		rp.Status = v
	}
	
	return rp
}
