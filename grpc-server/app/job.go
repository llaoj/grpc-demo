package app

import (
	"context"
	"io"

	"grpc-server/protobuf/gen"
)

type Job struct{}

func (j *Job) GetJob(ctx context.Context, in *gen.Job) (*gen.Job, error) {
	return &gen.Job {
		Id: in.Id,
		Name: "golang开发",
		CompanyName: "A技术公司",
		SalaryRange: &gen.SalaryRange {Min:10, Max:15},
	}, nil
}

// 一对多
func (j *Job) CompanyJobs(in *gen.Job, stream gen.JobService_CompanyJobsServer) error {
	for i := 1; i <= 3; i++ {
		job := &gen.Job {
			Id: int32(i),
			Name: "golang开发",
			CompanyName: in.CompanyName,
			SalaryRange: &gen.SalaryRange {Min:10, Max:15},
		}
		if err := stream.Send(job); err != nil {
			return err
		}
	}

	return nil
}

// 多对一
func (j *Job) AnalysisSalary(stream gen.JobService_AnalysisSalaryServer) error {
	var min, max int32 = 0,0;
	for {
		sr, err := stream.Recv()
		if err == io.EOF {
			return stream.SendAndClose(&gen.SalaryRange{
				Min: min,
				Max: max,
			})
		}
		if err != nil {
			return err
		}

		if sr.Min < min || min == 0 {
			min = sr.Min
		}

		if sr.Max > max {
			max = sr.Max
		}
	}
}

// 多对多
func (j *Job) GetJobs(stream gen.JobService_GetJobsServer) error {

	for {
		in, err := stream.Recv()
		if err == io.EOF {
			return nil
		}
		if err != nil {
			return err
		}

		rp := &gen.Job {
			Id: in.Id,
			Name: "golang开发",
			CompanyName: "A技术公司",
			SalaryRange: &gen.SalaryRange {Min:10, Max:15},
		}
		if err := stream.Send(rp); err != nil {
			return err
		}
	}
}
